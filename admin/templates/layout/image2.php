<div class="photoUpload-zone">
    <div class="photoUpload-detail" id="photoUpload-preview2">
        <?= $func->getImage(['class' => 'rounded', 'size-error' => '250x250x1', 'upload' => $photoDetail2['upload'], 'image' => $photoDetail2['image'], 'alt' => 'Alt Photo']) ?>
        <?php if(!empty($photoDetail2['image'])){?>
        <div class="delete-photo">
            <a href="javascript:void(0)" title="Xóa hình ảnh" data-action="<?=$photoAction?>" data-table="<?=$com?>" data-upload="<?=($com=='product')?'product':(($com=='photo')?'photo':'news')?>" data-id="<?=$item['id']?>"><i class="far fa-trash-alt"></i></a>
        </div>
        <?php }?>
    </div>
    <label class="photoUpload-file" id="photo-zone2" for="file-zone2">
        <input type="file" name="file2" id="file-zone2">
        <i class="fas fa-cloud-upload-alt"></i>
        <p class="photoUpload-drop"><?=keovathahinhvaoday?></p>
        <p class="photoUpload-or"><?=hoac?></p>
        <p class="photoUpload-choose btn btn-sm bg-gradient-success"><?=chonhinh?></p>
    </label>
    <div class="photoUpload-dimension"><?= $photoDetail2['dimension'] ?></div>
</div>