   <!-- footer section start -->
   <div style="background-color: #f7b6c4; margin-top:100px;">
    <div class="container mt-5">
      <div class="row pt-5">
        <div class="col-lg-4 col-md-6 px-3 mb-3">
          <h5>Skincare & Cosmetic</h5>
          <h6 class="my-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi eaque est minus.</h6>
          <div id="icon">
            <i class="fa-brands fa-facebook-f me-3"></i>
            <i class="fa-brands fa-instagram me-3"></i>
            <i class="fa-brands fa-tiktok"></i>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 px-3 mb-3">
          <h5>Categories</h5>
          <ul class="my-4 list-unstyled">
          <?php 
               $stmt = $pdo->query('SELECT * FROM categories');
               while($row = $stmt->fetch()):
          ?>
              <li class="mb-3"><a class="text-decoration-none text-black" href="shop.php?id=<?php echo $row['cat_id'] ?>&&tab=shop"><?php echo $row['cat_name'] ?></a></li>
          <?php endwhile ?>
          </ul>
        </div> 
        <div class="col-lg-3 col-md-3 px-3 mb-3">
          <h5>Quick Links</h5>
          <ul class="my-4 list-unstyled">
            <li class="mb-3"><a class="text-decoration-none text-black" href="./index.php?tab=home">Home</a></li>
            <li class="mb-3"><a class="text-decoration-none text-black" href="./about.php?tab=about">About</a></li>
            <li class="mb-3"><a class="text-decoration-none text-black" href="./contact.php?tab=contact">Contact</a></li>
            <li class="mb-3"><a class="text-decoration-none text-black" href="./product.php?tab=product">Search</a></li>
            <li class="mb-3"><a class="text-decoration-none text-black" href="./account.php?tab=account ">My Account</a></li>
          </ul>
        </div>  
        <div class="col-lg-3 col-md-4 px-3 mb-3">
          <h5>Contact Us</h5>
          <div class="my-4">
            <div class="d-flex icon1 mb-2">
              <i class="fa-solid fa-phone me-2 mt-1 "></i>
              <h6>+959891556130</h6>
            </div>
            <div class="d-flex icon1 mb-2">
              <i class="fa-solid fa-envelope me-2 mt-1 "></i>
              <h6>example@gmail.com</h6>
            </div>
            <div class="d-flex icon1 mb-2">
              <i class="fa-solid fa-map-location-dot me-2 mt-1"></i>
              <h6>Myanmar,yangon  </h6>
            </div>
          </div>
        </div>  
      </div>
    </div>
    </div>
    <div class="overlay" id="overlay" onclick="closeModal()"></div>
    <div id="model" style="background-color:white; width:35%; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; padding: 40px 20px; display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius:10px;">
    </div>
    <!-- footer section end -->
    <script>
    function myClick(id,detail,name,price,img){
      let model=document.querySelector('#model');
      model.innerHTML=`
      <h5 class="text-center mb-4">${name}(Price:${price}MMK)</h3>
      <p>${detail}</p>
      <div class="d-flex justify-content-between">
        <button onclick='addToCart(
          ${JSON.stringify(id)}, 
          ${JSON.stringify(detail)}, 
          ${JSON.stringify(name)}, 
          ${JSON.stringify(price)}, 
          ${JSON.stringify(img)}
        )'  class="home-btn text-white">Add To Cart</button>
        <button onclick="closeModal()" class="btn text-center" style="border:1px solid pink;">Cancle</button>
      </div>
      `;
     model.style.display = "block";
     document.getElementById("overlay").style.display = "block";
     
    }

    function closeModal() {
      document.getElementById("model").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }

    function addToCart(id,detail,name,price,img){
      let bag = JSON.parse(localStorage.getItem('bag')) || [];
      let existingProduct = bag.find(item => item.pro_id === id);

      if (existingProduct) {
        existingProduct.pro_qty += 1;
      } else {
        bag.push({
          pro_id: id,
          pro_name: name,
          pro_detail: detail,
          pro_price: price,
          pro_img: img,
          pro_qty: 1
        });
      }

      localStorage.setItem('bag', JSON.stringify(bag));
      alert(`${name} has been added to the bag!`);

      closeModal();
    }
                    
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>