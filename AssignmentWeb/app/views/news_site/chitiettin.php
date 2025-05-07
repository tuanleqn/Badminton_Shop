<?php

require 'config.php';
 if (isset($_GET['ID_tin'])) {
  $id_tin = $_GET['ID_tin'];

  // Chuẩn bị câu truy vấn
  $stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc WHERE ID_tin = :id_tin");
  $stmt->execute(['id_tin' => $id_tin]);

  // Lấy dữ liệu
  $row = $stmt->fetch();

  $sql = "SELECT * FROM bang_tin_tuc ORDER BY Ngay_viet DESC LIMIT 1";
  $stmt = $pdo->query($sql);
  $latestRow = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/stylenews.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <?php
    require_once __DIR__ . '/../../core/App.php';
    require_once __DIR__ . '/../../core/Controller.php';
    require_once __DIR__ . '/../../helper/URL.php'; 
    require_once __DIR__ . '/../../helper/config.php';
    require_once __DIR__ . '/../../helper/session.php'; 
    require_once dirname(__DIR__) . '/header_footer/header.php'; 
  ?>
    <div class="container_">
      <div class="detail-container">
        <div class="row_">
          <div class="left-detail-box">
            <div>
              <div class="blog-noibat">
                <span class="h2_sidebar_blog">
                  <p 
                    >Có thể bạn sẽ thích </p
                  >
                </span>
                <div class="blog_content">
                  <div class="item clearfix">
                    <div class="post-thumb">
                      <a href="<?php echo URL::to('public/News_site/chitiettin'); ?>?ID_tin=<?php echo $latestRow['ID_tin']?>"><img style="display:block; width:100px;height:60px;"src="<?php echo URL::to('app/views/news_site'); ?>/<?php echo $latestRow['Link_anh']?>" alt="" /></a>
                    </div>
                    <div class="contentright">
                      <h3>
                        <a href="<?php echo URL::to('public/News_site/chitiettin'); ?>?ID_tin=<?php echo $latestRow['ID_tin']?>"
                          ><?php echo $latestRow['Title']?></a
                        >
                      </h3>
                      <p><span><?php echo $latestRow['Ngay_viet']?></span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="right-content-detail">
              <div class="titlehead">Danh mục tin tức</div>
              <nav class="nav-category">
                <ul class="nav-pills">
                  <li class="nav-item relative">
                    <a
                      title="Thông Tin Tổng Hợp Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Thông Tin Tổng Hợp Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Câu Lạc Bộ - Nhóm Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Câu Lạc Bộ - Nhóm Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Thầy Dạy Đánh Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Thầy Dạy Đánh Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Tin tức VNB Sports"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Tin tức VNB Sports</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Chính sách"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Chính sách</a
                    >
                  </li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="right-detail-box">
            <div class="article-details clearfix">
              <div class="rte" style="text-align:unset!important">
                <div><h1 class="article-title"><?php echo $row['Title']?></h1></div>
                <div class="time-post">
                <i class="bi bi-clock"></i> <?php echo $row['Ngay_viet']?>
                <i style="margin-left:10px" class="bi bi-person-circle"></i> <?php echo $row['Nguoi_viet']?>
								</div>
                <?php echo $row['Noi_dung_tin']?>
              </div>
              
            </div>

            <div style="margin-bottom:50px" class="cmt-container">
              <p class="cmt-tt">Bình luận</p>
              <div class="cmt-box">
                <div class="avt-cmt">
                  <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                </div>
                <div class="cmt-form-container">
                  <form id="cmt-form">
                    <input style="display:none;" type="text" name="ID_tin" value="<?php echo $_GET['ID_tin']?>">
                    <div class="form-floating">
                      <textarea name="Noi_dung_cmt" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                      <label for="floatingTextarea2">Viết bình luận...</label>
                    </div>
                    <div class="bt-cmt overlay"><button type="submit"><i class="bi bi-chat-dots-fill"></i></button></div>
                  </form>
                </div>
              </div>
              <script>
                document.getElementById('cmt-form').addEventListener('submit', function(e) {
                  e.preventDefault(); // Ngăn reload

                  const formData = new FormData(this);
                  
                  fetch('<?php echo URL::to('public/News_site/process_comment'); ?>', {
                    method: 'POST',
                    body: formData
                  })
                  .then(res => res.json())
                  .then(data => {
                    if (data.success) {
                      const commentHTML = `
                        <hr>
                        <div class="cmt-box-container">
                          <div class="cmt-box">
                            <div class="avt-cmt">
                              <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                            </div>
                            <div class="cmt-form-container cmt-shadow">
                              <div>
                                <p class="cmt-username">${data.comment.name}</p>
                                <p>${data.comment.Noi_dung_cmt}</p>
                              </div>
                            </div>
                          </div>
                          <div style="margin-left:70px " class="cmt-time">
                            <span style="width:20%; display:inline-block">${data.comment.time_cmt}</span>
                            <a class="reply-cmt showContent" href=""><span><i class="bi bi-reply-all-fill"></i> Reply</span></a>
                          </div>
                        </div>
                      `;
                      document.getElementById('comment-list').insertAdjacentHTML('afterbegin', commentHTML);
                      document.getElementById('cmt-form').reset();
                    } else {
                      alert('Lỗi: ' + data.message);
                    }
                  });
                });
              </script>
              <div  id="comment-list">
              <?php
                  
                  $id_tin = $_GET['ID_tin'] ?? null;

                  if ($id_tin) {
                      $stmt = $pdo->prepare("SELECT c.*, u.name FROM bang_cmt c LEFT JOIN user u ON c.ID_user = u.id WHERE c.ID_tin = ? AND c.reply_to IS NULL ORDER BY c.time_cmt DESC");
                      $stmt->execute([$id_tin]);
                      $comments = $stmt->fetchAll();}
                      ?>
                      <?php foreach ($comments as $cmt): ?>
                        <hr>
                        <div class="cmt-box-container">
                          <div class="cmt-box">
                          <div id="reply-cmt<?php echo $cmt['ID_cmt']; ?>"></div>
                            <div class="avt-cmt">
                              <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                            </div>
                            <div class="cmt-form-container cmt-shadow">
                              <div>
                                <p class="cmt-username"><?php echo $cmt['name']?></p>
                                <p><?php echo $cmt['noi_dung_cmt']?></p>
                              </div>
                            </div>
                          </div>
                          <div style="margin-left:70px " class="cmt-time">
                            <span style="width:20%; display:inline-block"><?php echo $cmt['time_cmt']?></span>
                            <a class="reply-cmt showContent" href="" data-idcmt="<?php echo $cmt['ID_cmt']; ?>">
                              <span><i class="bi bi-reply-all-fill"></i> Reply</span>
                            </a>
                          </div>
                          
                        </div>
                        <?php
                          $id_reply= $cmt['ID_cmt'];
                          $stmt = $pdo->prepare("SELECT c.*, u.name FROM bang_cmt c LEFT JOIN user u ON c.ID_user = u.id WHERE c.reply_to = ? ORDER BY c.time_cmt DESC");
                          $stmt->execute([$id_reply]);
                          $replys = $stmt->fetchAll();
                        ?>
                        <?php foreach ($replys as $reply): ?>
                          <div class="cmt-box-container sub-cmt">
                            <div class="cmt-box">
                            <div id="reply-cmt<?php echo $cmt['ID_cmt']; ?>"></div>
                              <div class="avt-cmt">
                                <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                              </div>
                              <div class="cmt-form-container cmt-shadow">
                                <div>
                                  <p class="cmt-username"><?php echo $reply['name']?></p>
                                  <p><?php echo $reply['noi_dung_cmt']?></p>
                                </div>
                              </div>
                            </div>
                            <div style="margin-left:70px " class="cmt-time">
                              <span style="width:20%; display:inline-block"><?php echo $reply['time_cmt']?></span>
                              <a class="reply-cmt showContent" href="" data-idcmt="<?php echo $reply['ID_cmt']; ?>">
                                <span><i class="bi bi-reply-all-fill"></i> Reply</span>
                              </a>
                            </div>
                            
                          </div>
                        <?php endforeach; ?>
                      <?php endforeach; ?>

              </div>
                  
                  
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once dirname(__DIR__) . '/header_footer/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<script>
    document.querySelectorAll('.showContent').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Kiểm tra nếu đã tạo div kế bên rồi thì không tạo lại
            if (this.nextElementSibling && this.nextElementSibling.classList.contains('content-box')) {
                return;
            }
            const idcmt = this.dataset.idcmt; // Lấy ID_tin từ data attribute
        
            const div = document.createElement('div');
            div.className = 'content-box';

            div.innerHTML = `
                <div class="cmt-box">
                <div class="avt-cmt">
                  <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                </div>
                <div class="cmt-form-container">
                  <form id="cmt-form-sub" >
                    <input type="hidden" name="ID_cmt" value="${idcmt}">
                    <div class="form-floating">
                      <textarea name="Noi_dung_cmt" class="form-control" placeholder="Leave a comment here${idcmt}" id="floatingTextarea2" style="height: 100px"></textarea>
                      <label for="floatingTextarea2">Viết bình luận...</label>
                    </div>
                    <div class="bt-cmt overlay"><button type="submit"><i class="bi bi-chat-dots-fill"></i></button></div>
                  </form>
                </div>
              </div>
              
            `;
            this.insertAdjacentElement("afterend", div);


            const replyForm = div.querySelector('#cmt-form-sub');
            replyForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn reload

            const formData = new FormData(this);
            

            fetch('<?php echo URL::to('public/News_site/process_reply'); ?>', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                const commentHTML = `
                    <div class="cmt-box-container sub-cmt">
                    <div class="cmt-box">
                      <div class="avt-cmt">
                        <img src="<?php echo $latestRow['Link_anh']?>" alt="" class="avt-img">
                      </div>
                      <div class="cmt-form-container cmt-shadow">
                        <div>
                          <p class="cmt-username">${data.reply.name}</p>
                          <p>${data.reply.Noi_dung_cmt}</p>
                        </div>
                      </div>
                    </div>
                    <div style="margin-left:70px " class="cmt-time">
                      <span style="width:20%; display:inline-block">${data.reply.time_cmt}</span>
                      <a class="reply-cmt showContent" href=""><span><i class="bi bi-reply-all-fill"></i> Reply</span></a>
                    </div>
                  </div>
                `;
                document.getElementById(`reply-cmt${data.reply.ID_cmt}`).insertAdjacentHTML('afterbegin', commentHTML);

                document.getElementById('cmt-form-sub').reset();
              } else {
                alert('Lỗi: ' + data.message);
              }
            });
          });
        });
    });
</script>

              <script>
                
              </script>