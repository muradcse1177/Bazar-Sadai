<!DOCTYPE html>
<html>
<head>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body>
<p>
    Dear, {{$userName}}
</p>
<p>
    Greetings from <a href="bazar-sadai.com">Bazar-sadai.com.</a> Hope you are well!!
</p>
<h4> Your order transaction ID: {{@$tx_id}}</h4>
<h4> Thanks {{$userName}} for taking service from Bazar-sadai.com. Please check given email and phone number for confirmation.</h4>
<p>Thanks... </p>
<p>Best Regards, </p>
<p>Bazar-sadai.com </p>
</body>
</html>
