<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TacImage> $tacImages
 */
?>
<!--
<?php
print_r($objectList);
print_r($meta);
?>
-->
<div class="tacImages index content">
    <?= $this->Html->link(__('New Image'), ['action' => 'upload'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tac Images') ?></h3>
    <p><?= h($objectList['Name']) ?></p>
    <p><?= h($objectList['@metadata']['effectiveUri']) ?></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>key</th>
                    <th>size</th>
                    <th>etag</th>
                    <th>storage class</th>
                    <th>last modified</th>
                    <th>owner</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($objectList['Contents'] as $object): ?>
                <tr>
                    <td><?= h($object['Key']) ?></td>
                    <td><?= h($object['Size']) ?></td>
                    <td><?= h($object['ETag']) ?></td>
                    <td><?= h($object['StorageClass']) ?></td>
                    <td><?= h($object['LastModified']) ?></td>
                    <td><?= h($object['Owner']['DisplayName']) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('image', $meta['uriBase'] . h($object['Key'])) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $object['Key']], ['confirm' => __('Are you sure you want to delete # {0}?', $object['Key'])]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
