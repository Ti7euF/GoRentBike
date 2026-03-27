<?php foreach ($bikes as $bike): ?>
    <article class="card">
		<div class="slideshow">
				<?php foreach ($bike->getImages() as $index => $img): ?>
				<img src="/assets/img/<?= htmlspecialchars($img['path']) ?>" 
					alt="<?= htmlspecialchars($img['description']) ?>" 
					class="<?= $index === 0 ? 'show' : 'hide' ?>">
			<?php endforeach; ?>
		</div>
		<h3 class="name" title="<?= htmlspecialchars($bike->getBrand() . ' ' . $bike->getModel()) ?>">
			<?= htmlspecialchars($bike->getBrand() . ' ' . $bike->getModel()) ?>
		</h3>

        <div class="especs">
            <?php if ($bike->getSuspension()): ?>
                <span title="<?= htmlspecialchars($bike->getSuspension()) ?>">
					<?= htmlspecialchars($bike->getSuspension()) ?>
				</span>
            <?php endif; ?>

            <?php if ($bike->getTires()): ?>
                <span title="<?= htmlspecialchars($bike->getTires()) ?>">
					<?= htmlspecialchars($bike->getTires()) ?>
				</span>
            <?php endif; ?>

            <?php if ($bike->getGear()): ?>
                <span title="<?= htmlspecialchars($bike->getGear()) ?>">
					<?= htmlspecialchars($bike->getGear()) ?>
				</span>
            <?php endif; ?>

            <?php if ($bike->getSeatpost()): ?>
                <span title="<?= htmlspecialchars($bike->getSeatpost()) ?>">
					<?= htmlspecialchars($bike->getSeatpost()) ?>
				</span>
            <?php endif; ?>
        </div>

        <div class="price">
            <span><?= number_format($bike->getDailyPrice(), 2) ?> € / día</span>
        </div>

        <div class="add-cart">
            <a href="#">
                <span><i class="fa-solid fa-cart-arrow-down"></i>
            </a>
        </div>
    </article>
<?php endforeach; ?>