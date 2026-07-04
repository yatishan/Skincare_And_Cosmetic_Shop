<?php
session_start();

if(!$_SESSION['user_id']){
  header("location:login&register.php?tab=account");
}

include('./layout/navbar.php');

if(isset($_POST['order'])){
    date_default_timezone_set('asia/yangon');
    $order_date = date("Y-m-d h:i:s");
    $cus_id=$_SESSION['user_id'];
    $total_price=$_POST['total'];
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_price, order_date) VALUES (?, ?, ?)');
    $stmt->execute([$cus_id, $total_price, $order_date]);
    $order_id = $pdo->lastInsertId();
    $pro_id = $_POST['pro_id'];
    $qty = $_POST['qty'];
    $amount = $_POST['amount'];

      for ($i=0; $i < count($pro_id); $i++) { 
        $stmt = $pdo->prepare('INSERT INTO order_product (order_id, pro_id, op_qty, op_price) VALUES (?, ?, ?, ?)');
        $stmt->execute([$order_id, $pro_id[$i], $qty[$i], $amount[$i]]);

              // --- balance
        $stmt = $pdo->prepare('SELECT * FROM balances WHERE pro_id = ? ORDER BY bal_id DESC LIMIT 1');
        $stmt->execute([$pro_id[$i]]);
        $balance_data = $stmt->fetch();

        if ($balance_data) {
          $balance = $balance_data['bal_qty'];

          $latest_balance = $balance - $qty[$i];

          $stmt = $pdo->prepare('INSERT INTO balances (income_date, income_qty, bal_qty, pro_id, sale_qty) VALUES (?, ?, ?, ?, ?)');
          $stmt->execute([$order_date, '0', $latest_balance, $pro_id[$i], $qty[$i]]);
        } else {
          echo "<script>alert('Balance not found for product ID: $pro_id[$i]');</script>";
        }
        
      }

      echo ("<script>
        function done(){
          localStorage.clear();
        }
        done();
        alert('Order Done');

      </script>"); 
}
?>

<div class="container">
    <h5 class="my-5 text-center">Shopping Cart</h5>
    <form action="" method="post">
    <table class="table" border="1">
      <thead class="table-danger"  style="background-color: pink;">
        <tr>
          <th scope="col">Product</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">Total</th>
          <th scope="col">Action</th>
        </tr>
      </thead>

      <tbody id="cart-items">
        <!-- Example Product Row -->
        
        <!-- Add more products dynamically here -->
      </tbody>
    </table>
    <div action="" method="post" class="d-flex justify-content-end my-5">
        <div style="width: 300px; border: 1px solid pink; background-color:#F6F6F6;">
        <div class="d-flex justify-content-between px-3 pt-3" style="border-bottom: 1px solid pink; ">
            <p>Total Amount</p>
            <p id="check_total"></p>
            <input type="hidden" name="total" id="total-all">
        </div>
        <input type="submit" name="order" value="Order Now" class="home-btn text-white float-end my-3 me-3">
        </div>
    </div>
    </form>
</div>
<script>
    let bag = JSON.parse(localStorage.getItem('bag')) || [];

    function loadData() {      
      let tbody = document.querySelector('tbody');
      tbody.innerHTML = ``;
      let total_all = 0;

      if (bag.length === 0) {
        tbody.innerHTML = `
          <h3 class="text-center my-5">Empty cart...</h3>
        `;
      } else {
        bag.forEach(item => {
          const total_each = item.pro_price * item.pro_qty; 
          total_all += total_each; 

          tbody.innerHTML += `
            <tr style="background-color: #F6F6F6;">
              <td>
                <div class="d-flex align-items-center">
                  <img src="./image/${item.pro_img}" class="img-thumbnail me-3" style="width: 100px;" alt="Product Image">
                  <span>${item.pro_name}</span>
                  <input type="hidden" value="${item.pro_id}" name="pro_id[]" id="pro_id">
                </div>
              </td>
              <td>${item.pro_price}MMK</td>
              <td>
                <div class="d-flex align-items-center">
                  <button onclick="changeQty('decrease', '${item.pro_id}')" class="btn btn-sm btn-outline-secondary decrement">-</button>
                  <input name="qty[]" type="text" class="form-control text-center mx-2 qty-input" style="width: 60px;" value="${item.pro_qty}">
                  <button onclick="changeQty('increase', '${item.pro_id}')" class="btn btn-sm btn-outline-secondary increment">+</button>
                </div>
              </td>
              <td class="item-total">MMK<input name="amount[]" class="total-each" type="number" readonly style="border: none; outline: none;" value="${total_each}"></td>
              <td>
                <button onclick="removeItem('${item.pro_id}')" class="home-btn btn-sm text-white px-3">Delete</button>
              </td>
            </tr>
          `;
        });
        document.querySelector('#check_total').textContent= total_all+"MMK";
        document.querySelector('#total-all').value= total_all;
      }
    }

    function changeQty(status, id) {
      const index = bag.findIndex(item => item.pro_id == id);

      if (index !== -1) {
        if (status === 'decrease') {
          bag[index].pro_qty -= 1;
        } else if (status === 'increase') {
          bag[index].pro_qty += 1;
        }

        if (bag[index].pro_qty <= 0) {
          bag.splice(index, 1);
        }

        localStorage.setItem('bag', JSON.stringify(bag));
        loadData(); 
      }
    }


    function removeItem(id) {
      const index = bag.findIndex(item => item.pro_id == id);
      bag.splice(index, 1);
      localStorage.setItem('bag', JSON.stringify(bag));
      loadData(); 
    }

    // Load data on page load
    document.addEventListener('DOMContentLoaded', loadData);
</script>
<?php
include('./layout/footer.php')
?>