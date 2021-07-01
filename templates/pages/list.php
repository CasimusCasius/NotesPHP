<div class="list">
    <section>
        <div class="message">
            <?php if (!empty($params['before']))
            {
                switch ($params['before'])
                {
                    case 'created':
                        echo 'Notatka została utworzona !';
                        break;
                    case 'edited':
                        echo 'Zmiany w notatce zostały zapisane !';
                        break;
                }
            } ?>
        </div>
        <div class="error">
            <?php if (!empty($params['error']))
            {
                switch ($params['error'])
                {
                    case 'noteNotFound':
                        echo 'Notatka nie została znaleziona !';
                        break;
                    case 'missingNoteId':
                        echo 'Błędny parametr!';
                        break;
                }
            } ?>


        </div>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data wpisu</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php foreach ($params['notes'] ?? [] as $note) : ?>
                        <tr>
                            <td><?php echo $note['id'] ?></td>
                            <td><?php echo $note['title'] ?></td>
                            <td><?php echo $note['created'] ?></td>
                            <td><a href="/?action=show&id=<?php echo $note['id'] ?>"><button>Podgląd</button></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>