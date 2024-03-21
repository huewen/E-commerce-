<?php 
	//load LayoutTrangChu.php
	$this->layoutPath = "LayoutTrangTrong.php";
 ?>
 	<div class="template-cart">
          <form action="index.php?controller=cart&action=update" method="post">
            <div class="table-responsive">
              <table class="table table-cart">
                <thead>
                  <tr>
                    <th class="image">Ảnh sản phẩm</th>
                    <th class="name">Tên sản phẩm</th>
                    <th class="price">Giá bán lẻ</th>
                    <th class="quantity">Số lượng</th>
                    <th class="price">Thành tiền</th>
                    <th>Xóa</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($_SESSION["cart"] as $product): ?>
                  <tr>
                    <td><img src="assets/upload/products/<?php echo $product['photo']; ?>" class="img-responsive" /></td>
                    <td><a href="index.php?controller=products&action=detail&id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></td>
                    <td> <?php echo number_format($product['price']); ?>₫ </td>
                    <td><input type="number" id="quantity" min="1" class="input-control" value="<?php echo $product['number']; ?>" name="product_<?php echo $product['id']; ?>" required="Không thể để trống"></td>
                    <td><p><b><?php echo number_format($product['number']*$product['price']); ?>₫</b></p></td>
                    <td><a href="index.php?controller=cart&action=delete&id=<?php echo $product['id']; ?>" data-id="2479395"><i class="fa fa-trash"></i></a></td>
                  </tr>
              	<?php endforeach; ?>
                </tbody>
                <?php if($this->cartNumber() > 0): ?>
                <tfoot>
                  <tr>
                    <td colspan="6"><a href="index.php?controller=cart&action=destroy" class="button pull-left">Xóa toàn bộ</a> <a href="index.php" class="button pull-right black">Tiếp tục mua hàng</a>
                      <input type="submit" class="button pull-right" value="Cập nhật"></td>
                  </tr>
                </tfoot>
            	<?php endif; ?>
              </table>
            </div>
          </form>

          <?php if($this->cartNumber() > 0): ?>
            
            <div class="total-cart"> Tổng tiền thanh toán:
              <?php echo number_format($this->cartTotal()); ?>₫ <br>
              <a href="index.php?controller=cart&action=checkout"  class="button black">Thanh toán</a> 
              <div style="text-align: center;" class="total-cart">Hình thức thanh toán online</div>

              <?php 
              $vnd_to_usd = round($this->cartTotal()/23000,2);
              ?>
              <div style="width: 300px;" id="paypal-payment-button"></div>
                <input type="hidden" id="vnd_to_usd" 
                value="<?php echo $vnd_to_usd; ?>">
            </div>
          <?php endif; ?>
            
           
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AV3J8WChJOGZV608ovPdEx0z0sjSyODS902qgqZiyiK4Ss9vRGBVEBqyLs_DXi3koa59yhawlpEIyygI">
</script>
<script>
  var usd = document.getElementById("vnd_to_usd").value;
  paypal.Buttons({
  style: {
      color: 'blue',
      shape: 'pill'
  },
  createOrder:function(data, actions){
    return actions.order.create({
      purchase_units:[{
        amount:{
          value:`${usd}`
        }
      }]
    });
  },
  onApprove:function (data, actions){
    return actions.order.capture().then(function(details){
      console.log(details);
      alert("Xử lý thanh toán thành công, bấm THANH TOÁN để hoàn tất");
    }) 
    destroy();
  },
  onCancel:function(data){
    alert("Xử lý thanh toán thất bại")
  }
}).render('#paypal-payment-button');
</script>

