from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium import webdriver
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

url = 'https://pacs.osha.gov.tw/2875/?Page=1&PageSize=99999'
# url = 'https://pacs.osha.gov.tw/2875/?Page=1&PageSize=10'

driver = webdriver.Chrome(service=s,
                          options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上


class MajorOccupationalAccident:
    # 建構式
    def __init__(self, business_unit, industry, detail_of_industry, accident_type, occurrence_date, number_of_victims, business_owner, project_name, accident_location, accident_address, notifying_agency):
        self.business_unit = business_unit
        self.industry = industry
        self.detail_of_industry = detail_of_industry
        self.accident_type = accident_type
        self.occurrence_date = occurrence_date
        self.number_of_victims = number_of_victims
        self.business_owner = business_owner
        self.project_name = project_name
        self.accident_location = accident_location
        self.accident_address = accident_address
        self.notifying_agency = notifying_agency  # 勞動檢查機構


driver.get(url)  # 訪問URL
index = 0
accidentList = driver.find_elements(By.CLASS_NAME, 'publiclist')
for accident in accidentList:
    listgropup01 = accident.find_element(
        By.CLASS_NAME, 'listgroup01').find_elements(By.TAG_NAME, 'li')
    listgropup02 = accident.find_element(
        By.CLASS_NAME, 'listgroup02').find_elements(By.TAG_NAME, 'li')
    _industry = listgropup01[0].text.split('：')[1].split('(')
    notifying_agency = listgropup02[3].text.split('勞動檢查機構')[1]
    if (_industry[0] == '營造業'):
        _industry[0] = '營建工程業'
    if (_industry[0] == '資訊及通訊傳播業'):
        _industry[0] = '出版影音及資通訊業'
    if (_industry[0] == '業別10'):
        _industry[0] = '未分類'
    if (notifying_agency == '新竹科學園區管理局'):
        notifying_agency = '國家科學及技術委員會新竹科學園區管理局'
    if (notifying_agency == '中部科學園區管理局'):
        notifying_agency = '國家科學及技術委員會中部科學園區管理局'
    if (notifying_agency == '南部科學園區管理局'):
        notifying_agency = '國家科學及技術委員會南部科學園區管理局'
    if (notifying_agency == ''):
        notifying_agency = '無'
    notifying_agencyId = execSql("SELECT `id` FROM `notifying_agencies` WHERE agency_name='{notifying_agency}'"
                                 .format(notifying_agency=notifying_agency)).fetchone()[0]
    industryCode = execSql("SELECT `code` FROM `industries` WHERE name='{industry}'"
                           .format(industry=_industry[0])).fetchone()[0]
    accident_typeCode = execSql("SELECT code FROM `accident_types` WHERE name='{accident_type}'"
                                .format(accident_type=listgropup01[1].text.split('：')[1])).fetchone()[0]
    occurrenceDateSplit = listgropup01[2].text.split('：')[1].split('/')
    occurrenceDate = str(int(occurrenceDateSplit[0]) + 1911) + \
        '-' + occurrenceDateSplit[1] + '-' + occurrenceDateSplit[2]
    moa = MajorOccupationalAccident(
        business_unit=accident.find_element(
            By.CLASS_NAME, 'business_unit').text.split('：')[1],
        industry=industryCode,
        detail_of_industry=_industry[1][:-1],
        accident_type=accident_typeCode,
        occurrence_date=occurrenceDate,
        number_of_victims=listgropup01[3].text.split('：')[1],
        business_owner=listgropup01[4].text.split('：')[1],
        project_name=listgropup02[0].text.split('工程名稱')[1],
        accident_location=listgropup02[1].text.split('場所(肇災處)')[1],
        accident_address=listgropup02[2].text.split('地址')[1],
        notifying_agency=notifying_agencyId,
    )
    moaDict = moa.__dict__

    primaryKeys = ['business_unit', 'occurrence_date', 'project_name']
    values = [moa.business_unit, moa.occurrence_date, moa.project_name]
    columns = list(moaDict.keys())
    datas = list(moaDict.values())
    index += 1
    # SQL
    if (checkRowIsExists('major_occupational_accidents', primaryKeys, values)):  # 確認是否有此筆資料，有此筆
        execSql(updateOneRow('major_occupational_accidents',
                columns, datas, primaryKeys, values))  # 更新資料
        print('更新第{i}筆'.format(i=index))
    else:  # 沒有此筆資料
        execSql(insertOneRow('major_occupational_accidents', columns, datas))  # 則寫入
        print('寫入第{i}筆'.format(i=index))


print('執行成功')
