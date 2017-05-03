<?php if(isset($this->data['notifications']) and $this->data['notifications']): ?>
<?php foreach($this->data['notifications'] as &$note): ?>

    <div class="note-item">
        
        <div class="note-body">
            <?php
               echo NotificationHelper::getNotificationHTML($note);
            ?>
            
        </div>
    </div>

<?php endforeach; ?>
<?php else: ?>
<p class="no-wishes">შეტყობინებები არ მოიძებნა</p>
<?php endif; ?>