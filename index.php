<?php
require_once("./config/dbConfig.php");
function getShortDescription($description, $wordLimit = 20)
{
    $word = explode(' ', $description);
    if (count($word) > $wordLimit) {
        return implode(' ', array_slice($word, 0, $wordLimit)) . ".... للمزيد";
    } else {
        return $description;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astredia - الرئيسية</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="lib/awesome/css/all.min.css">
</head>

<body>
    <?php
    require_once('./parts/navbar.php');
    ?>
    <br>
    <section class="hero">
        <div class="hero-item hero-large anime-start">
            <img src="imgs/hero/1.jpg" alt="Hero Image 1" loading="lazy">
        </div>
        <div class="hero-item hero-small">
            <div class="small-img anime-start">
                <img src="imgs/hero/2.jpg" alt="Hero Image 2" loading="lazy">
            </div>
            <div class="small-img anime-start">
                <img src="imgs/hero/3.webp" alt="Hero Image 3" loading="lazy">
            </div>
        </div>
    </section>
    <br>

    <section class="features-bar">
        <div class="feature-item">
            <i class="fas fa-headset"></i>
            <p>دعم <strong>24 ساعة</strong><br>متاح على مدار الأسبوع </p>
        </div>
        <div class="feature-item">
            <i class="fas fa-undo-alt"></i>
            <p>خدمة <strong>إرجاع </strong><br>استبدال المنتج خلال 14 يوما </p>
        </div>
        <div class="feature-item">
            <i class="fas fa-truck"></i>
            <p>شحن <strong>سريع</strong><br>توصيل في خلال 48 ساعة</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-shield-alt"></i>
            <p>دفع <strong>آمن</strong><br>طرق دفع متنوعة </p>
        </div>
        <br>
        <hr class="hr-header">
    </section>
    <br>
    <div class="heading">
        <h1 class="secondary-text">فئات</h1>
    </div>
    <br>
    <section class="categories-bar" id="categories">
        <?php
        $categories_query = "SELECT * FROM `categories`";
        $categories_result = mysqli_query($conn, $categories_query);
        if (mysqli_num_rows($categories_result) > 0) {
            while ($category = mysqli_fetch_assoc($categories_result)) {
        ?>
                <div class="category-item a-text">
                    <a href="#">
                        <img src="categories/<?php echo $category['img'] ?>" alt="" loading="lazy">
                        <br>
                        <h3><?php echo $category['name'] ?></h3>
                    </a>
                </div>
            <?php
            }
        } else {
            ?>
            <h3 class="a-text" style="text-align: center;">عذرا لم يتم العثور علي شئ !</h3>
        <?php
        }
        ?>
        <hr class="hr-header">
    </section>
    <br>
    <div class="heading">
        <h1 class="secondary-text">منتجات</h1>
    </div>
    <br>
    <section class="products">
        <?php
        $products_query = "SELECT * FROM products LIMIT 6";
        $products_result = mysqli_query($conn, $products_query);
        if (mysqli_num_rows($products_result) > 0) {
            while ($product = mysqli_fetch_assoc($products_result)) {
                $store_id = $product['store_id'];
                $store_query = "SELECT * FROM stores WHERE id = $store_id";
                $store_result = mysqli_query($conn, $store_query);
                $store = mysqli_fetch_assoc($store_result);

                $sales_query = "SELECT COUNT(*) as sale_count FROM sales WHERE product_id = " . $product['id'];
                $sales_result = mysqli_query($conn, $sales_query);
                $sales_data = mysqli_fetch_assoc($sales_result);
        ?>
                <div class="product">
                    <div class="product-img">
                        <?php
                        if (isset($product['discount']) && $product['discount'] > 0) {
                        ?>
                            <div class="discount">
                                <h3>وفر <?php echo $product['discount'] ?>%</h3>
                            </div>
                        <?php
                        }
                        ?>
                        <img src="pages/stores/<?php echo $store['name'] ?>/<?php echo $product['img'] ?>" alt="" loading="lazy">
                    </div>
                    <div class="product-detiles">
                        <h2><?php echo $product['name'] ?></h2>
                        <br>
                        <h3>السعر : <?php echo $product['price'] ?>$</h3>
                        <p><?php echo getShortDescription($product['descrip']) ?></p>
                        <p>تم بيع <?php echo $sales_data['sale_count'] ?> قطع الي الان ! <strong><sup>من <?php echo $store['name'] ?></sup></strong></p>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <h3 class="a-text" style="text-align: center;">لم يتم العثور علي منتجات</h3>
        <?php
        }
        ?>
        <hr class="hr-header">
    </section>

    <br>
    <div class="heading">
        <h1 class="secondary-text">المدونة</h1>
    </div>
    <br>

    <section class="posts">
        <?php
        $posts = "SELECT * FROM blog limit 6";
        $conn_posts = mysqli_query($conn, $posts);
        if (mysqli_num_rows($conn_posts) > 0) {
            while ($post = mysqli_fetch_assoc($conn_posts)) {
        ?>
                <div class="post">
                    <div class="post-img">
                        <div class="discount">
                            <h3>جديد</h3>
                        </div>
                        <img src="imgs/posts/<?php echo $post['img'] ?>" alt="" srcset="" loading="lazy">
                    </div>
                    <div class="post-detiles">
                        <h2><?php echo $post['name'] ?></h2>
                        <br>
                        <p><?php echo getShortDescription($post['descrip']) ?></strong></p>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <h3 class="a-text" style="text-align: center;">لم يتم العثور علي منشورات</h3>
        <?php
        }
        ?>

    </section>
    <br>
    <?php
    require_once('./parts/footer.php');
    ?>

    <script>
        // JavaScript to toggle the FAQ answers
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>

</html>