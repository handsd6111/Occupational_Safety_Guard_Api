
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
import sys
sys.path.append('../')
from sql.common import execSql, checkRowIsExists, insertOneRow, updateOneRow

chrome_options = Options()
chrome_options.add_argument('--no-sandbox')
chrome_options.add_argument('--disable-dev-shm-usage')
chrome_options.add_argument('--headless')  # 啟動Headless 無頭
chrome_options.add_argument('--disable-gpu')  # 關閉GPU 避免某些系統或是網頁出錯

s = Service(r"./tools/chromedriver.exe")

url = 'https://insp.osha.gov.tw/labcbs/manual/disaddrbook.htm'

driver = webdriver.Chrome(service=s,
                          options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上

driver.get(url)  # 訪問URL
table = driver.find_element(By.TAG_NAME, 'table').find_element(
    By.TAG_NAME, 'table')
trList = table.find_elements(By.TAG_NAME, 'tr')
for index, tr in enumerate(trList):
    if index == 0:  # 首欄是欄位名稱
        continue  # 跳過
    tdList = tr.find_elements(By.TAG_NAME, 'td')
    agency_name = tdList[0].text  # 機關名稱
    address = tdList[1].text  # 地址
    hotlines = (tdList[2].text  # 讀取上下班通報專線資料
                .replace("(", "")  # 先移除 (
                .replace(")", "-")  # 將 ) 換成 -
                .replace("上班時間: ", "")  # 移除 上班時間:
                .split("\n下班時間: "))  # 剩下 "上班熱線"\n下班時間: "下班熱線"，使用split分割取得上班跟下班的時間
    columns = ['agency_name', 'address',
               'notified_hotline_at_work', 'notified_hotline_off_work']  # notifying_agencies的欄位
    datas = [agency_name, address, hotlines[0], hotlines[1]]
    
    # SQL
    if(checkRowIsExists('notifying_agencies', ['agency_name'], [agency_name])): # 確認是否有此筆資料，有此筆
        execSql(updateOneRow('notifying_agencies',columns, datas, ['agency_name'], [agency_name])) # 更新資料
    else: # 沒有此筆資料
        execSql(insertOneRow('notifying_agencies', columns, datas)) # 則寫入
        
    # 取得此notifying_agency的id
    na_id = execSql("SELECT id FROM `notifying_agencies` WHERE `agency_name`='{agency_name}'".format(
        agency_name=agency_name)).fetchone()[0]
    
    # 管轄區
    regions = tdList[3].text.split("、")  # 分割管轄區
    for region in regions:
        region = region.split('\n(')[0]  # 消除 (公告授權) 的字句
        columns = ['region']  # jurisdiction_regions的欄位
        datas = [region]  # jurisdiction_regions的資料
        primaryKeys = columns  # 此表的主鍵等同於所有欄位，直接賦值
        values = datas  # 此表的主鍵等同於所有欄位，直接賦值

        # SQL
        if(checkRowIsExists('jurisdiction_regions', primaryKeys, values)): # 確認是否有此筆資料，有此筆
            execSql(updateOneRow('jurisdiction_regions', columns, datas, primaryKeys, values)) # 更新資料
        else: # 沒有此筆資料
            execSql(insertOneRow('jurisdiction_regions', columns, datas)) # 則寫入

        # 取得此notifying_agency的id
        jr_id = execSql("SELECT id FROM `jurisdiction_regions` WHERE `region`='{region}'".format(
            region=region)).fetchone()[0]

        columns = ['na_id', 'jr_id'] 
        datas = [na_id.__str__(), jr_id.__str__()]
        primaryKeys = columns  # 此表的主鍵等同於所有欄位，直接賦值
        values = datas  # 此表的主鍵等同於所有欄位，直接賦值
        
        # SQL
        if(checkRowIsExists('notifying_agency_regions', primaryKeys, values)): # 確認是否有此筆資料，有此筆
            execSql(updateOneRow('notifying_agency_regions', columns, datas, primaryKeys, values)) # 更新資料
        else: # 沒有此筆資料
            execSql(insertOneRow('notifying_agency_regions', columns, datas)) # 則寫入
