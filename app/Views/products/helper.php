<?php foreach ($products as $product) : ?>
    <span>[</span></br>
    <span>'id' => '<?= $product['id'] ?>',</br></span>
    <span>'name' => "<?= $product['name'] ?>",</br></span>
    <span>'category' => '<?= $product['category'] ?>',</br></span>
    <span>'price' => <?= $product['price'] ?>,</br></span>
    <span>'stock' => <?= $product['stock'] ?>,</br></span>
    <span>'created_at' => '<?= $product['created_at'] ?>',</br></span>
    <span>'updated_at' => '<?= $product['updated_at'] ?>',</br></span>
    <span>],</span></br>
<?php endforeach; ?>