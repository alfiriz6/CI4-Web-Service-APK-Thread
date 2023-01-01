<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Service Intergalactic Science Kingdom</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            justify-content: center;
            background: url('giphy.gif');
            background-size: cover;
            overflow: hidden;
        }

        h2 {
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 14px;
            text-align: center;
            color: white;
        }

        .clock {
            display: flex;
        }

        .clock div {
            margin: 5px;
            position: relative;
        }

        .clock span {
            width: 100px;
            height: 80px;
            background: slateblue;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .clock .text {
            height: 30px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: darkblue;
            opacity: 0.8;
        }

        .clock #ampm {
            bottom: 0;
            position: absolute;
            width: 60px;
            height: 30px;
            font-size: 20px;
            background: darkblue;
        }
    </style>
</head>

<body>
    <h2>Web Service Intergalactic Science Kingdom</h2>
    <div class="clock">
        <div>
            <span id="hour">00</span>
            <span class="text">Hours</span>
        </div>
        <div>
            <span id="minutes">00</span>
            <span class="text">Minutes</span>
        </div>
        <div>
            <span id="seconds">00</span>
            <span class="text">Seconds</span>
        </div>
        <div>
            <span id="ampm">AM</span>
        </div>
    </div>
    <script>
        const hourEl = document.getElementById('hour')
        const minutesEl = document.getElementById('minutes')
        const secondsEl = document.getElementById('seconds')
        const ampmEl = document.getElementById('ampm')


        //function to get time from computer
        function getClock() {
            let hr = new Date().getHours()
            let m = new Date().getMinutes()
            let s = new Date().getSeconds()
            let ampm = 'AM'

            if (hr <= 12) {
                ampm = 'AM'
            } else {
                hr = hr - 12
                ampm = 'PM'
            }

            //short form of if statement
            hr = hr < 10 ? '0' + hr : hr;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;

            hourEl.innerText = hr
            minutesEl.innerText = m
            secondsEl.innerText = s
            ampmEl.innerText = ampm
            setTimeout(() => {
                getClock()
            }, 1000)
        }

        //call and refresh after every seconds
        getClock()
    </script>
</body>

</html>