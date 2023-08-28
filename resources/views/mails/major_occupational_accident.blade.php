<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* * {
            margin: 0;
            padding: 0;
            list-style: none;
        } */

        * {
            color: black;
        }

        .container {
            padding: 0;
            /* margin: 0 auto; */
            max-width: 1200px
        }

        .publicblock .publicTb {
            width: 100%
        }

        .publicblock {
            padding: 1em 0
        }

        .publicblock .publiclist {
            padding: 1.5em;
            border: 1px solid #ccc;
            border-radius: 0.2em;
            margin-bottom: 1em
        }

        .title {
            font-size: 2.3em;
            font-weight: bold;
        }

        .sub-title {
            font-size: 1.1rem;
            color:#999;
            margin-top: 0;
            margin-bottom: 1.3rem;
        }

        .publicblock .publiclist .business_unit {
            background-color: #265fa6;
            color: #fff;
            padding: .3em 1em;
            margin-bottom: 1em;
            display: inline-block;
            border-radius: 0.2em;
            font-size: 1.4em;
        }

        .publicblock .publiclist .listgroup01 {
            margin: 0 0 1em;
            padding: 0;
            width: 100%;
            list-style-type: none;
            display: flex;
            flex-wrap: wrap;
            font-size: 1.05rem;
        }

        .publicblock .publiclist .listgroup01 li {
            flex: 0 0 auto;
            margin-left: 0;
            padding-right: 1em;
            margin-right: 1em;
            position: relative;
            /* font-size: 0.938em */
        }

        .publicblock .publiclist .listgroup01 li:after {
            content: '';
            width: 1px;
            height: 20px;
            background-color: #ccc;
            position: absolute;
            right: 0;
            top: 3px;
            color: #fff
        }

        .publicblock .publiclist .listgroup01 li:last-child:after {
            display: none
        }

        @media screen and (max-width: 575px) {

            .container {
                padding: 0;
                margin: 0 auto;
                max-width: 350px;

            }

            .publicblock .publiclist .listgroup01 {
                display: block;
            }

            .publicblock .publiclist .listgroup01 li {
                padding: 0 0 0 1em;
                margin: 0;
            }

            .publicblock .publiclist .listgroup01 li:after {
                display: none
            }

            .publicblock .publiclist .listgroup01 li:before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background-color: #666;
                position: absolute;
                left: 0;
                top: 10px
            }
        }

        .publicblock .publiclist .listgroup02 {
            margin: 0;
            padding: 0;
            list-style-type: none
        }

        .publicblock .publiclist .listgroup02 li {
            margin-left: 0;
            margin-bottom: .5em;
            font-size: 1.05rem;
            /* padding: 0 0 0 135px */
        }

        .publicblock .publiclist .listgroup02 li span {
            min-width: 120px;
            display: inline-block;
            background-color: #eee;
            text-align: center;
            margin-right: 1.2rem;
            padding: 2px;
            border-radius: 50px;
            /* margin-left: -135px; */
            font-weight: bolder;
            font-size: 1.15rem;
        }

        .publicblock .publiclist .listgroup02 li:last-child {
            margin-bottom: 0
        }

        @media screen and (max-width: 575px) {
            .publicblock .publiclist .listgroup02 li {
                padding: 0;
                margin: 0
            }

            .publicblock .publiclist .listgroup02 li span {
                width: calc(100% - 1em);
                /* min-width: 100%; */
                display: block;
                margin-right: 0;
                margin-left: 0;
                margin-top: .5em;
                margin-bottom: .5em;
                text-align: left;
                padding: 3px .5em
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="publicblock publicTb table_list">
            <div class="publiclist">
                <div class="title">新的重大職災事件</div>
                <p class="sub-title">掃描時間: {{ $moa['scan_time'] }}</p>
                <div class="business_unit">事業單位：{{ $moa['business_unit'] }}</div>
                <ul class="listgroup01">
                    <li><span>行業別：</span>{{ $moa['industry'] }}({{ $moa['detail_of_industry'] }})</li>
                    <li><span>災害類型：</span>{{ $moa['accident_type'] }}</li>
                    <li><span>發生日期：</span>{{ $moa['occurrence_date'] }}</li>
                    <li><span>罹災人數：</span>{{ $moa['number_of_victims'] }}</li>
                    <li><span>業主：</span>{{ $moa['business_owner'] }}</li>
                </ul>
                <ul class="listgroup02">
                    <li><span>工程名稱</span>{{ $moa['project_name'] }}</li>
                    <li><span>場所(肇災處) </span>{{ $moa['accident_location'] }}</li>
                    <li><span>地址</span>{{ $moa['accident_address'] }}</li>
                    <li><span>勞動檢查機構</span>{{ $moa['notifying_agency'] }}</li>
                </ul>
            </div>
        </div>
        <!-- 您會收到此封信件，則表示您有訂閱我們的服務。 -->
    </div>
</body>

</html>