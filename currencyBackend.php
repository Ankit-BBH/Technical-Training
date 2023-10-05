<?php
    session_start();
    $conn = mysqli_connect("localhost","root","1494","lib") or die();
    function checkupdate($conn){
        $query = mysqli_query($conn,"Select time from exc limit 1;");
        $row = mysqli_fetch_assoc($query);

        $start = strtotime($row['time']);
        $end = strtotime(date("H:i"));

        $minutes = floor(($end - $start) / 60);
        if($minutes > 30){
            return true;
        }
        else{
            return false;
        }
   
    }

    function getdata(){
        $endpoint = 'latest';
        $access_key = '8e6745dfbec93b770e5d769ff7f8ad32';
    
        // Initialize CURL:
        $ch = curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
    
        // Decode JSON response:
        $exc = json_decode($json, true);
        var_dump($exc);
        return $exc;
    }
    if(isset($_POST['submit'])){
        $amt = $_POST['amt'];
        $from = $_POST['from_currency'];
        $to = $_POST['to_currency'];
        
        if(checkupdate($conn)){
            
            $data = getdata();
            $time= date("H:i:s");
            foreach($data as $sub){
                foreach($sub as $id=>$value){
                    $query2=mysqli_query($conn,"Update exc set rate='$value',time='$time' where name='$id';");  
                }
            }

            $exchange = (float)($trate/$frate);
            $total= $exchange*$amt;
        
            $_SESSION['status'] = $total;

            header("Location: Currency.php");

        }
        else{
            $selectQuery = mysqli_query($conn,"Select (select rate from exc where name='$to')/(select rate from exc where name='$from') as data from exc limit 1;");
            $my = mysqli_fetch_assoc($selectQuery);

            $total= (float)$my['data']*$amt;
    
            $_SESSION['status'] = $total;
            header("Location: Currency.php");
        }

    }


?>