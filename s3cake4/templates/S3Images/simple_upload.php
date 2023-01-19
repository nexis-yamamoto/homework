<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TacImage> $tacImages
 */
?>
<div class="tacImages index content">
  <form method="post" enctype="multipart/form-data">
    <div>
      <input type="file" name="my_file">
      <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
      <button type="submit">アップロード</button>
    </div>
  </form>
</div>
