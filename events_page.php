











<div class="p-y-lg" id="">
    <div class="container p-y-lg text-primary-hover">
      <h1 class="display-3 _700 l-s-n-3x m-t-lg m-b-md">Hello, <span style="color:#98282a!important" class="text-primary"><?php echo strtoupper($rowSponsorName['sponsor_name']) ?></span> </h1>
      <h5 class="text-muted m-b-lg">Choose your organized event.</h5>
      <div class="row m-y-lg">
        <?php
        while ($rowEvents = mysqli_fetch_assoc($resEvents)) {
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="box white box-shadow-z3 text-center">
              <a>
                <!--  <img class="img-responsive b-b m-b" src="../assets/image.jpg" alt="default"> --><br>
                <span class="_800 p-a block h4 m-a-0"><?php echo $rowEvents['event_name'] ?></span>
              </a>
              <div class="box-body">
                <p>
                  <a href="organizer.php?sponsor_id=<?php echo $sponsor_id ?>&username=<?php echo $username ?>&event_id=<?php echo $rowEvents['event_id'] ?>"><span class="btn btn-sm rounded text-u-c _700" style="background-color: #98282a; color: #ECDCDC">
                      Select
                    </span></a>
                </p>
              </div>

            </div>
          </div>
        <?php } ?>
      </div>
      <h5 class="m-y-lg text-muted text-center">It's time for an amazing event!</h5>
    </div>
  </div>
  </div>