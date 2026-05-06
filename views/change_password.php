<div style="padding: 40px; color: white;">
    <h1>Смена пароля</h1>
    
    <?php if (!empty($message)): ?>
        <p style="background: #333; padding: 10px; border-radius: 5px; color: #4CAF50;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" style="display: flex; flex-direction: column; max-width: 300px; gap: 15px;">
        <label>Новый пароль:</label>
        
        <!-- Обертка для поля и иконки -->
        <div style="position: relative; display: flex; align-items: center;">
            <input type="password" name="new_password" id="password_input" required 
                   style="padding: 8px; padding-right: 40px; border-radius: 4px; border: 1px solid #444; background: #222; color: white; width: 100%;">
            
            <!-- Иконка глазика -->
            <span id="toggle_password" style="position: absolute; right: 10px; cursor: pointer; user-select: none;">
                👁️
            </span>
        </div>
        
        <button type="submit" 
                style="padding: 10px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px;">
            Сохранить новый пароль
        </button>
    </form>
</div>

<script>
document.getElementById('toggle_password').addEventListener('click', function () {
    const passwordInput = document.getElementById('password_input');
    // Переключаем тип поля: если password -> text, и наоборот
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.textContent = '🔒'; // Можно менять иконку на закрытый замок
    } else {
        passwordInput.type = 'password';
        this.textContent = '👁️';
    }
});
</script>