<form id="UpdateContactForm" action="javascript:;" method="post">
  <div class="msg">

  </div>
  <label for="">Name</label>
  <input type="text" name="name" value="<?= $data[0]['name']?>">
  <br>
  <label for="">Phone Number</label>
  <input type="text" name="phone" value="<?= $data[0]['phone']?>">
  <br>
  <button type="submit">Submit</button>
</form>
