<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dynamic depend select boxes</title>
    <style type="text/css">
        .container{
            width:280px;
            text-align: center;
        }
        select{
            background-color:#f5f5f5;
            border: 1px solid #fb4314;
            color:#55bb91;
            font-family: arial;
            font-weight: bold;
            font-size: 14px;
            height: 39px;
            padding: 7px 8px;
            width:250px;
            outline:none;
            margin:10px 0 10px 0;
        }
        select option{
            font-size: 16px;
            font-family: georgia;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <?php 
            // Include the database config file 
            include_once 'dbConfig.php'; 
             
            // Fetch all the country data 
            $query = "SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC"; 
            $result = $db->query($query); 
        ?>

        <!-- Country dropdown -->
        <select id="country">
            <option value="">Select Country</option>
            <?php 
            if($result->num_rows > 0){ 
                while($row = $result->fetch_assoc()){  
                    echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>'; 
                } 
            }else{ 
                echo '<option value="">Country not available</option>'; 
            } 
            ?>
        </select>

        <!-- State dropdown -->
        <select id="state">
            <option value="">Select country first</option>
        </select>

        <!-- City dropdown -->
        <select id="city">
            <option value="">Select state first</option>
        </select>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            $('#country').on('change', function(){
                var countryID = $(this).val();
                if(countryID){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'country_id='+countryID,
                        success:function(html){
                            $('#state').html(html);
                            $('#city').html('<option value="">Select state first</option>'); 
                        }
                    }); 
                }else{
                    $('#state').html('<option value="">Select country first</option>');
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            });
            
            $('#state').on('change', function(){
                var stateID = $(this).val();
                if(stateID){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'state_id='+stateID,
                        success:function(html){
                            $('#city').html(html);
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            });
        });
        </script>
</body>
</html>