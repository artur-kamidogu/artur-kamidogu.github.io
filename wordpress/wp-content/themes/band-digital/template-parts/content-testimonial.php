<!--  TESTIMONIAL AREA START  -->
<section id="testimonial" class="section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <div class="mb-5">
              <h3 class="mb-2"><?php if (!empty ($args['custom_title'])){echo $args['custom_title'];}
                  else echo 'Наши клиенты';?></h3>
              <p>
              <?php if (!empty ($args['custom_description'])){echo $args['custom_description'];}
                  else echo 'Ниже представлены отзывы от клиентов, с которыми <br/>
                  мы работаем уже несколько лет подряд';?>
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 m-auto col-sm-12 col-md-12">
            <div class="carousel slide" id="test-carousel2">
              <div class="carousel-inner">
                
                <?php
                    global $post;
                    $cnt=0;
                    $query = new WP_Query( [
                        'posts_per_page' =>4 ,
                        'post_type'        => 'testimonial',
                    ] );
                    ?>
                <ol class="carousel-indicators">
                  <li data-target="#test-carousel2" data-slide-to="0" class="active"></li>
                  <?php 
                  for ($i=1;$i<count($query ->posts);$i++){
                    ?>
                    <li data-target="#test-carousel2" data-slide-to="<?php echo $i;?>"></li>
                    <?php 
                  }?>
                </ol>
                    <?php
                        
                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            $cnt++;
                            switch ($cnt){
                                case "1":?>
                                <?php 
                                break;

                                default: ?>
                                <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                    <div class="testimonial-content style-2">
                                        <div class="author-info">
                                        <div class="author-img">
                                            <img src="<?php echo get_the_post_thumbnail_url();?>" alt="" class="img-fluid" />
                                        </div>
                                        </div>

                                        <p>
                                        <i class="icofont icofont-quote-left"></i><?php the_excerpt();?> <i class="icofont icofont-quote-right"></i>
                                        </p>
                                        <div class="author-text">
                                        <h5><?php the_title();?></h5>
                                        <p><?php echo get_post_meta($post->ID,'role',true)?></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <?php 
                                break;
                            }
                            ?>
                            <div class="carousel-item ">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                    <div class="testimonial-content style-2">
                                        <div class="author-info">
                                        <div class="author-img">
                                            <img src="<?php echo get_the_post_thumbnail_url();?>" alt="" class="img-fluid" />
                                        </div>
                                        </div>

                                        <p>
                                        <i class="icofont icofont-quote-left"></i><?php the_excerpt();?> <i class="icofont icofont-quote-right"></i>
                                        </p>
                                        <div class="author-text">
                                        <h5><?php the_title();?></h5>
                                        <p><?php echo get_post_meta($post->ID,'role',true)?></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            <?php
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                    ?>
                
                <!--  ITEM END  -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  TESTIMONIAL AREA END  -->