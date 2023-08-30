
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
import time
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

driver = webdriver.Chrome(options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上


class Industry:
    # 建構式
    def __init__(self, code, name):
        self.code = code  # 行業代碼
        self.name = name  # 行業名稱

print('開始抓取「行業別」資料：')
start = time.time()

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
        
end = time.time()
print('執行成功，總共耗時 %f 秒' % (end - start))