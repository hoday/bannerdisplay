<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">
        ID
      </th>
      <th scope="col">
        Image
      </th>
      <th scope="col">
        Start date
      </th>
      <th scope="col">
        End date
      </th>
      <th scope="col">
        Allowed ips
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($banners as $banner): ?>
    <tr id="<?php  echo $banner['banner_id']; ?>">
      <th scope="row">
        <?php echo $banner['banner_id']; ?>
      </th>
      <td id="<?php echo 'banner_path'.'-'.$banner['banner_id'];?>" class="banner-path">
        <img src="<?php echo $banner['banner_path']; ?>" />
      </td>
      <td id="<?php echo 'start_date'.'-'.$banner['banner_id'];?>" class="banner-date">
        <?php echo ($banner['start_date'])->format($formatString); ?>
      </td>
      <td id="<?php echo 'end_date'.'-'.$banner['banner_id'];?>" class="banner-date">
        <?php echo ($banner['end_date'])->format($formatString); ?>
      </td>
      <td>
        <?php foreach($banner['allowed_ips'] as $allowed_ip) : ?>
          <div>
            <?php echo $allowed_ip; ?>
          </div>
        <?php endforeach; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<style>
  .td-hover-active {
    background-color: #CCDDFF;
  }

  .td-edit-active {
    background-color: #AABBFF;
  }
</style>

<script src="assets/banner_setup.js"></script>
