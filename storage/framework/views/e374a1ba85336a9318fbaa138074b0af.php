<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحقق من البريد الإلكتروني</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* سماوي */
            color: #000080; /* أسود */
            text-align: center;
        }
        h1 {
            color: #000080; /* أزرق داكن */
        }
    </style>
</head>
<body>
    <h1>تحقق من البريد الإلكتروني</h1>
    <p>الرجاء النقر على الرابط أدناه للتحقق من بريدك الإلكتروني:</p>
    <a id="verifyButton" href="<?php echo e(route('verify.email', ['token' => $token])); ?>">تحقق من البريد الإلكتروني</a>
    <p id="verificationStatus"></p>
    <script>
        // تعيين معالج الحدث للرابط
        document.getElementById('verifyButton').addEventListener('click', function(event) {
            event.preventDefault(); // منع إعادة تحميل الصفحة بعد النقر على الرابط
            // إرسال طلب POST باستخدام Fetch API
            fetch(this.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '_token=<?php echo e(csrf_token()); ?>&token=<?php echo e($token); ?>'
            })
            .then(response => response.json())
            .then(data => {
                // عرض حالة التحقق
                document.getElementById('verificationStatus').textContent = data.message;
                // إخفاء الرابط بعد التحقق
                document.getElementById('verifyButton').style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\ahmad\Desktop\senior2_2\resources\views/email/verifyEmail.blade.php ENDPATH**/ ?>