<html>
    <head>
        <title>GPS position system</title>
        <meta charset="UTF-8">
        <style>
            table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            }

            td, th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            tr:nth-child(even){background-color: #f2f2f2;}

            tr:hover {background-color: #ddd;}

            th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: red;
            color: white;
            }
        </style>
    </head>

    <body>
        <table style="width:100%">
        <tr>
            <th>Number</th>
            <th>Altitude</th>
            <th>Long</th>
            <th>Message</th>
        </tr>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pole = $_POST['message'];
            
            if(empty($pole) == false)
            {
                $plik = fopen("text.txt", "a") or die("it's impossible to open the file");
                
                fwrite($plik, "\n".$pole);
                fclose($plik);
            }
            
        }
        // Data in text file - create file in your repository
        $pliczek = fopen("text.txt", "r") or die("The file is not exists"); 
        $index = 0;
        while(!feof($pliczek)) {
            $out = fgets($pliczek)."<br>";
            $lat = floatval(substr($out, 0, strpos($out, ",")));
            $long = floatval(substr($out, strpos($out, ",")+2));
            $mess ="<span style='color: red;'>OUT OF THE AREA !!!</span>";
            // Set restricted coordinates
            $lat_min = 52.000;
            $lat_max = 53.000;
            $long_min = 19.903;
            $long_max = 19.924;
            if($lat && $long)
            {
                if(
                $long >= $long_min && $long <= $long_max && $lat >= $lat_min && $lat <= $lat_max){ 
                    $index++; 
                    echo "<tr>
                    <td>$index</td>
                    <td>$lat</td>
                    <td>$long</td>
                    <td></td>
                    </tr>";
                }
                else {
                    $index++; 
                    echo "<tr>
                    <td>$index</td>
                    <td>$lat</td>
                    <td>$long</td>
                    <td>$mess</td>
                    </tr>";
                }
            }
        }
        fclose($pliczek);
        echo "</table>";

        header("refresh: 10"); 

        ?>
        <br><br>
        <form method="POST" action="map.html" style= "display: flex; justify-content: right;">
            <input type="submit" value="Check the current localization on the map!">
        </form>
    </body>
</html>



