from env import *
import pymysql


def execSql(sql: str):
    ''' 執行SQL
        @param sql str 執行的SQL語句
        @return Cursor 可透過此物件的function在外部實作
    '''
    # 資料庫連線設定
    # 可縮寫db = pymysql.connect("localhost","root","root","30days" )
    db = pymysql.connect(host=host,
                         port=port,
                         user=user,
                         password=password,
                         database=database,
                         charset=charset)
    # 建立操作游標
    cursor = db.cursor()

    # 執行語法
    try:
        cursor.execute(sql)
        # 提交修改
        db.commit()
    except:
        # 發生錯誤時停止執行SQL
        db.rollback()
        print('error-sql:')
        print(sql)
    # 關閉連線
    db.close()
    return cursor


def primaryKeysCondition(primaryKeys: list, values: list):
    ''' 建立Primary Key的條件字串
        @param primaryKeys list 主鍵陣列
        @param values list 配合主鍵陣列的值
        @return str SQL語句
    '''
    condition = ''  # 建立字串
    for index in range(len(primaryKeys)):
        condition += primaryKeys[index] + "='" + \
            values[index] + "' AND "  # 結合所有條件
    condition = condition[:-4]  # 刪除最後的 " AND"
    return condition  # 回傳條件字串


def checkRowIsExists(table: str, primaryKeys: list, values: list):
    ''' 檢查此筆資料是否存在於資料表中
        @table 欲檢查的資料表
        @param primaryKeys list 主鍵陣列
        @param values list 配合主鍵陣列的值
        @return bool True=有此筆資料、False=無此筆資料
    '''
    condition = primaryKeysCondition(primaryKeys, values)  # 建立條件字串
    # 將主鍵作條件來查詢，若結果不為None，則表示無此筆資料，回傳False。
    if (execSql(("SELECT * FROM {table} WHERE {condition}").format(
            table=table,
            condition=condition
    )).fetchone() == None):
        return False
    # 沒判斷成立則表示有此筆資料，回傳True
    return True


def insertOneRow(table: str, columns: list, datas: list):
    ''' 寫入一筆資料進資料庫
        @table 欲寫入的資料表
        @param columns list 欲寫入的欄位陣列
        @param datas list 對應欄位陣列的資料
        @return str SQL語句
    '''
    columnString = '(' # 建立欄位字串
    dataString = '(' # 建立資料字串
    for i in range(len(columns)):
        columnString += "`{column}`,".format(column=columns[i]) # 結合所有欄位
        dataString += "'{data}',".format(data=datas[i]) # 結合所有資料
    columnString = columnString[:-1] + ")" # 刪除 "," 並且加上 ")"
    dataString = dataString[:-1] + ")" # 刪除 "," 並且加上 ")"
    return ("INSERT INTO `{table}`{columnString} VALUES {dataString}"
            .format(
                table=table,
                columnString=columnString,
                dataString=dataString
            ))


def updateOneRow(table: str, columns: list, datas: list, primaryKeys: list, values: list):
    ''' 更新資料庫中的一筆資料
        @table 欲更新的資料表
        @param columns list 欲更新的欄位陣列
        @param datas list 對應欄位陣列的資料
        @param primaryKeys 欲更新資料的主鍵陣列，作為條件更新依據
        @param values 對應主鍵陣列的值
        @return str SQL語句
    '''
    columnAndDataString = '' # 建立欄位以及值字串
    for i in range(len(columns)):
        columnAndDataString += "`{column}`='{data}',".format(
            column=columns[i],
            data=datas[i]
        )
    columnAndDataString = columnAndDataString[:-1] # 移除 ","
    return ("UPDATE `{table}` SET {columnAndDataString} WHERE {conditionString}"
            .format(
                table=table,
                columnAndDataString=columnAndDataString,
                conditionString=primaryKeysCondition(primaryKeys, values)
            ))
