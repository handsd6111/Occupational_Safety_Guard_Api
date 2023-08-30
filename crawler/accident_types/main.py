from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium import webdriver
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

url = 'https://insp.osha.gov.tw/labcbs/dis0001.aspx'

driver = webdriver.Chrome(options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上


class AccidentType:
    # 建構式
    def __init__(self, code, name):
        self.code = code  # 行業代碼
        self.name = name  # 行業名稱
        
print('開始抓取「災害類型」資料：')
start = time.time()


driver.get(url)  # 訪問URL
# print(driver.page_source)
driver.find_element(By.ID, 'btndisnotify').click()

accidentSelect = driver.find_element(By.ID, 'a_DT_code')  # 資料分成兩堆
# print(accidentSelect)
optionList = accidentSelect.find_elements(By.TAG_NAME, 'option')

for index, option in enumerate(optionList):
    if index == 0:
        continue

    # print(option.text)
    splitOptionText = option.text.split(') ')
    code = splitOptionText[0][1:]
    name = splitOptionText[1]
    accidentType = AccidentType(code, name)
    accidentTypeDict = accidentType.__dict__
    primaryKeys = ['code']
    values = [accidentType.code]
    columns = list(accidentTypeDict.keys())
    datas = list(accidentTypeDict.values())
    # SQL
    if (checkRowIsExists('accident_types', primaryKeys, values)):  # 確認是否有此筆資料，有此筆
        execSql(updateOneRow('accident_types',
                columns, datas, primaryKeys, values))  # 更新資料
    else:  # 沒有此筆資料
        execSql(insertOneRow('accident_types', columns, datas))  # 則寫入

end = time.time()
print('執行成功，總共耗時 %f 秒' % (end - start))
