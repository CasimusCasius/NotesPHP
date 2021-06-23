<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if (!empty($note)) : ?>
    <ul>
        <li>ID: <?php echo $note['id'] ?></li>
        <li>Tytuł: <?php echo $note['title'] ?></li>
        <li>Treść: <?php echo $note['description'] ?></li>
        <li>Zapisano: <?php echo $note['created'] ?></li>
    </ul>
    
    <?php else: ?>
        <div>
            Brak notatki do wyświetlenia
        </div>
    <?php endif; ?>
    <a href="/"><button>Powrót do listy</button></a>
</div>