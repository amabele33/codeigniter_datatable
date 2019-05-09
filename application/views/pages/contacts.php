<div class="contact" style="display:block; width:400px;margin:0 auto;">
  <input type="text" name="search" value="" placeholder="Search here">
  <button type="button" class="searchbtn">Search</button>
  <br>
  <a href="<?= base_url('add_contact_here') ?>" class="add">Add Contact</a>
  <div class="">
    <?php echo $this->session->flashdata('msg'); ?>
  </div>
  <?php
    if(count($results) == 0){
      echo "Sorry, no results found";
    }
    foreach ($results as $key => $value) {
      ?>
      <div class="">
        <?= $value->id.' '.$value->name.' '.$value->phone; ?>
        <a href="javascript:;" class="delete" data-id="<?= $value->id ?>">Delete</a>
        <a href="<?= base_url('update_here/'.$value->id) ?>" class="update" data-id="<?= $value->id ?>">Update</a>
      </div>
      <?php
    }

   ?>
   <div class="">
     <?php print_r($pagination); ?>
   </div>
</div>
