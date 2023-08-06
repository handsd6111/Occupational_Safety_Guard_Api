
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
# 加上表頭，模擬真人
chrome_options.add_argument(
    "user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3")

s = Service(r"./tools/chromedriver.exe")

url = 'https://www.stat.gov.tw/StandardIndustrialClassification.aspx?n=3144&sms=11195&RID=11'

driver = webdriver.Chrome(service=s,
                          options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上


class Industry:
    # 建構式
    def __init__(self, code, name):
        self.code = code  # 行業代碼
        self.name = name  # 行業名稱


driver.get(url)  # 訪問URL
# print(driver.page_source)
cols = driver.find_elements(By.CLASS_NAME, 'col-md-6')  # 資料分成兩堆
liList = cols[0].find_elements(By.TAG_NAME, 'li')
liList += cols[1].find_elements(By.TAG_NAME, 'li')
for li in liList:
    code = li.find_element(By.TAG_NAME, 'a').text[0]
    name = li.text.split('- ')[1]
    industry = Industry(code, name)
    industryDict = industry.__dict__
    primaryKeys = ['code']
    values = [industry.code]
    columns = list(industryDict.keys())
    datas = list(industryDict.values())
    # columns = ['code', 'name']  # notifying_agencies的欄位
    # datas = [agency_name, address, hotlines[0], hotlines[1]]
    # SQL
    if (checkRowIsExists('industries', primaryKeys, values)):  # 確認是否有此筆資料，有此筆
        execSql(updateOneRow('industries',
                columns, datas, primaryKeys, values))  # 更新資料
    else:  # 沒有此筆資料
        execSql(insertOneRow('industries', columns, datas))  # 則寫入

print('執行成功')
# industrys = liList.find_elements(By.TAG_NAME, 'li')
# for index, industry in enumerate(industrys):
    # print(industry.text[0])
# table = driver.find_element(By.TAG_NAME, 'table').find_element(
#     By.TAG_NAME, 'table')
# trList = table.find_elements(By.TAG_NAME, 'tr')
# for index, tr in enumerate(trList):
#     if index == 0:  # 首欄是欄位名稱
#         continue  # 跳過
#     tdList = tr.find_elements(By.TAG_NAME, 'td')
#     agency_name = tdList[0].text  # 機關名稱
#     address = tdList[1].text  # 地址
#     hotlines = (tdList[2].text  # 讀取上下班通報專線資料
#                 .replace("(", "")  # 先移除 (
#                 .replace(")", "-")  # 將 ) 換成 -
#                 .replace("上班時間: ", "")  # 移除 上班時間:
#                 .split("\n下班時間: "))  # 剩下 "上班熱線"\n下班時間: "下班熱線"，使用split分割取得上班跟下班的時間
#     columns = ['agency_name', 'address',
#                'notified_hotline_at_work', 'notified_hotline_off_work']  # notifying_agencies的欄位
#     datas = [agency_name, address, hotlines[0], hotlines[1]]

#     # SQL
#     if(checkRowIsExists('notifying_agencies', ['agency_name'], [agency_name])): # 確認是否有此筆資料，有此筆
#         execSql(updateOneRow('notifying_agencies',columns, datas, ['agency_name'], [agency_name])) # 更新資料
#     else: # 沒有此筆資料
#         execSql(insertOneRow('notifying_agencies', columns, datas)) # 則寫入

#     # 取得此notifying_agency的id
#     na_id = execSql("SELECT id FROM `notifying_agencies` WHERE `agency_name`='{agency_name}'".format(
#         agency_name=agency_name)).fetchone()[0]

#     regions = tdList[3].text.split("、")  # 分割管轄區
#     for region in regions:
#         aregion = region.split('(')[0]  # 消除 (公告授權) 的字句
#         columns = ['na_id', 'region']  # jurisdiction_regions的欄位
#         datas = [na_id.__str__(), region]  # jurisdiction_regions的資料
#         primaryKeys = columns  # 此表的主鍵等同於所有欄位，直接賦值
#         values = datas  # 此表的主鍵等同於所有欄位，直接賦值

#         # SQL
#         if(checkRowIsExists('jurisdiction_regions', primaryKeys, datas)): # 確認是否有此筆資料，有此筆
#             execSql(updateOneRow('jurisdiction_regions', columns, datas, primaryKeys, values)) # 更新資料
#         else: # 沒有此筆資料
#             execSql(insertOneRow('jurisdiction_regions', columns, datas)) # 則寫入
