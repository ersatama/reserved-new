<form action="https://api.paybox.money/v1/merchant/538109/card/pay" method="post" style="visibility: hidden;">
    <input type="text" placeholder="pg_merchant_id" name="pg_merchant_id" value="{{$payment['pg_merchant_id']}}" required><br><br>
    <input type="text" placeholder="pg_payment_id" name="pg_payment_id" value="{{$payment['pg_payment_id']}}" required><br><br>
    <input type="text" placeholder="pg_salt" name="pg_salt" value="{{$payment['pg_salt']}}" required><br><br>
    <input type="text" placeholder="pg_sig" name="pg_sig" value="{{$payment['pg_sig']}}" required><br><br>
    <input type="submit" id="submit_btn">
</form>
<script>
    document.getElementById('submit_btn').click();
</script>
