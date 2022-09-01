<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Code</title>
</head>
<body>
    
<div class="visible-print text-center">
    <h1>Laravel 6 - QR Code Generator Example</h1> 
        
    <a href="https://www.vinayafitclub.com" target="_blank">
        <img align="right" src= "data:image/png;base64,{{base64_encode(QrCode::encoding('ISO-8859-1')->format('png')->size(300)->generate('testing'))}}">
    </a>

    <p>example by Testing.</p>
</div>
    
</body>
</html>