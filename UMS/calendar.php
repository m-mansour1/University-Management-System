<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}

$st_id = $_SESSION['admin_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Week Calendar</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400|Roboto+Condensed:400|Fjalla+One:400'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <?php include('AdminSidebar.php');
    ?>
    <style>
        body {
            overflow: scroll;
        }

        .calendar-wrapper {
            width: 1280px;
            margin: 3em auto;
            padding: 2em;
            border: 1px solid #dcdcff;
            border-radius: 5px;
            background: #fff;
        }

        .calendar-wrapper table {
            clear: both;
            width: 100%;
            border: 1px solid #dcdcff;
            border-radius: 3px;
            border-collapse: collapse;
            color: #444;
        }

        .calendar-wrapper td {
            height: 48px;
            text-align: center;
            vertical-align: middle;
            border-right: 1px solid #dcdcff;
            border-top: 1px solid #dcdcff;
            width: 14.28571429%;
        }

        thead td {
            border: none;
            color: #28283b;
            text-transform: uppercase;
            font-size: 1.5em;
        }

        td.not-current {
            color: #c0c0c0;
        }

        td.today {
            font-weight: 700;
            color: #28283b;
            font-size: 1.5em;
        }

        #btnPrev {
            float: left;
            margin-bottom: 20px;
        }

        #btnPrev:before {
            content: '\f104';
            font-family: FontAwesome;
            padding-right: 4px;
        }

        #btnNext {
            float: right;
            margin-bottom: 20px;
        }

        #btnNext:after {
            content: '\f105';
            font-family: FontAwesome;
            padding-left: 4px;
        }

        #btnPrev,
        #btnNext {
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #c0c0c0;
            cursor: pointer;
            font-family: "Roboto Condensed", sans-serif;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        #btnPrev:hover,
        #btnNext:hover {
            color: #28283b;
            font-weight: bold;
        }
    </style>
    <script>
        var Cal = function(divId) {
            this.divId = divId;
            this.DaysOfWeek = [
                'Sun',
                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat'
            ];
            this.Months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            var d = new Date();
            this.currMonth = d.getMonth();
            this.currYear = d.getFullYear();
            this.currDay = d.getDate();

        };
        Cal.prototype.nextMonth = function() {
            if (this.currMonth == 11) {
                this.currMonth = 0;
                this.currYear = this.currYear + 1;
            } else {
                this.currMonth = this.currMonth + 1;
            }
            this.showcurr();
        };
        Cal.prototype.previousMonth = function() {
            if (this.currMonth == 0) {
                this.currMonth = 11;
                this.currYear = this.currYear - 1;
            } else {
                this.currMonth = this.currMonth - 1;
            }
            this.showcurr();
        };
        Cal.prototype.showcurr = function() {
            this.showMonth(this.currYear, this.currMonth);
        };
        Cal.prototype.showMonth = function(y, m) {
            var d = new Date()
                ,
                firstDayOfMonth = new Date(y, m, 1).getDay()
                ,
                lastDateOfMonth = new Date(y, m + 1, 0).getDate()
                ,
                lastDayOfLastMonth = m == 0 ? new Date(y - 1, 11, 0).getDate() : new Date(y, m, 0).getDate();
            var html = '<table>';
            html += '<thead><tr>';
            html += '<td colspan="7">' + this.Months[m] + ' ' + y + '</td>';
            html += '</tr></thead>';
            html += '<tr class="days">';
            for (var i = 0; i < this.DaysOfWeek.length; i++) {
                html += '<td>' + this.DaysOfWeek[i] + '</td>';
            }
            html += '</tr>';
            var i = 1;
            do {
                var dow = new Date(y, m, i).getDay();
                if (dow == 0) {
                    html += '<tr>';
                }
                else if (i == 1) {
                    html += '<tr>';
                    var k = lastDayOfLastMonth - firstDayOfMonth + 1;
                    for (var j = 0; j < firstDayOfMonth; j++) {
                        html += '<td class="not-current">' + k + '</td>';
                        k++;
                    }
                }
                var chk = new Date();
                var chkY = chk.getFullYear();
                var chkM = chk.getMonth();
                if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) {
                    html += '<td class="today">' + i + '</td>';
                } else {
                    html += '<td class="normal">' + i + '</td>';
                }
                if (dow == 6) {
                    html += '</tr>';
                }
                else if (i == lastDateOfMonth) {
                    var k = 1;
                    for (dow; dow < 6; dow++) {
                        html += '<td class="not-current">' + k + '</td>';
                        k++;
                    }
                }
                i++;
            } while (i <= lastDateOfMonth);
            html += '</table>';
            document.getElementById(this.divId).innerHTML = html;
        };
        window.onload = function() {
            var c = new Cal("divCal");
            c.showcurr();
            getId('btnNext').onclick = function() {
                c.nextMonth();
            };
            getId('btnPrev').onclick = function() {
                c.previousMonth();
            };
        }
        function getId(id) {
            return document.getElementById(id);
        }
    </script>
    <br>
    <div class="home_content">
        <div class="calendar-wrapper">
            <button id="btnPrev" type="button">Prev</button>
            <button id="btnNext" type="button">Next</button>
            <div id="divCal"></div>
        </div>


    </div>
</body>

</html>