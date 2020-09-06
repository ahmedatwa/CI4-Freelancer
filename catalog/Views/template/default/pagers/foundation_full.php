
    <div class="pagination_fg">
    <?php if ($pager->hasPrevious()) : ?>
            <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
            <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
            <a class="active" href="<?= $link['uri'] ?>">
                <?= $link['title'] ?>
            </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
            <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
    <?php endif ?>
    </div>
