<?php
    session_start();
    require 'get.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Weather site</title>
    <link href="style/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        #map {
            height: 30%;
            width: 30%;
        }

        div#map a,
        div#map button,
        div.gm-bundled-control {
            display: none !important;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #6e6e84;
            color: white;
        }
    </style>

    <?php
        if ($_POST) {
            $_SESSION['city_id'] = $_POST['city_id'];
        } else {
            $_SESSION['city_id'] = 695859;

        }
        $data = new GetWeatherData($_SESSION['city_id'], 'ru');
        $info = $data->getData();
    ?>
    <script>
        const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        let labelIndex = 0;

        function initMap() {
            const bangalore = { <?php echo 'lat:' . $info->coord->lat . ',' . 'lng:' . $info->coord->lon?> };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: bangalore,
            });

            addMarker(bangalore, map);
        }

        function addMarker(location, map) {
            new google.maps.Marker({
                position: location,
                label: labels[labelIndex++ % labels.length],
                map: map,
            });
        }
    </script>
</head>

<body>

<div class="container">
    <h1 class="text-center" style="font-size: 40px">Погода в городе
        <form class="d-inline-block" name="form" action="" method="post">
            <select class="form-select form-select-lg m-2" name="city_id" onchange="form.submit()">
                <?php
                    foreach ($data->cities as $key => $value)
                    {
                ?>
                <option value="<?php echo $key . '"';
                    if ($key == $_SESSION['city_id']) {
                        echo 'selected';
                    }
                ?>><?php echo $value ?>
                    </option>
                    <?php
                    }
                ?>
            </select>
        </form>
    </h1>

    <div class=" text-center
                ">
                <h6 style="font-size: 30px">

                    <p class="mb-0">Страна: <?php echo $info->sys->country ?></p>
                    <p class="mb-0">Рассвет в <?php echo date('G:i', $info->sys->sunrise + $info->timezone) ?>, а закат
                        в <?php echo date('G:i', $info->sys->sunset + $info->timezone) ?>
                    <p>(по местному времени)</p>
                    <p class="mb-0">Сейчас в городе <?php echo $info->name . ' ' . $info->weather[0]->description ?>
                        <img src="http://openweathermap.org/img/wn/<?php echo $info->weather[0]->icon ?>@2x.png"
                             alt="Weather"
                             height="70px">
                    </p>
                    <p class="mb-0">Температура: <?php echo $info->main->temp ?> ℃ ,ощущается
                        как: <?php echo $info->main->feels_like ?> ℃</p>
                    <p class="mb-0"><b>Min: </b><?php echo $info->main->temp_min ?>℃ ,
                        <b>Max: </b><?php echo $info->main->temp_max ?> ℃</p>
                </h6>
</div>


</div>


<div class="text-center" style="font-size: 30px">
    <p class="mb-0">Давление <b><?php echo $info->main->pressure ?></b> Па</p>
    <p class="mb-0">Влажность <b><?php echo $info->main->humidity ?></b>%</p>
    <p class="mb-0">Хмарность <b><?php echo $info->clouds->all ?></b>%</p>
    <p class="mb-0">Скорость ветра <b><?php echo $info->wind->speed ?></b> м/c</p>
</div>

<div id="map" class="container"></div>


<p class="text-center" style="font-size: 28px">Информация
    обновлена <?php echo date('Y-m-d в H:i', $info->dt + $info->timezone) ?> </p>


<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg1f9eLKxf3uFsSexhujoe042QTg_rHHs&callback=initMap">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous"></script>
</body>
</html>




