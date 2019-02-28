<div class="modal fade" id="callback">
    <div class="modal-dialog modal-dialog-centered modal-callback">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <? require get_template_directory() . "/assets/img/icons/times.svg" ?>
            </button>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="label">Ваше имя</label>
                        <input type="text" name="name" class="control-form" placeholder="Введите имя">
                    </div>
                    <div class="form-group input-validate">
                        <label class="label">Ваш номер телефона</label>
                        <input type="tel" name="phone" class="control-form phone" required
                               placeholder="+7 (___) ___-__-__">
                        <div class="error-text">Пожалуйста, введите телефон.</div>
                    </div>
                    <div class="text-center">
                        <button class="button btn-yellow w-100" type="submit">перезвоните мне</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sorry">
    <div class="modal-dialog modal-dialog-centered modal-callback">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <? require get_template_directory() . "/assets/img/icons/times.svg" ?>
            </button>
            <div class="modal-body">
                <div class="title-main text-center">Ошибка обратной связи<br>Попробуйте отправить позже</div>
            </div>
        </div>
    </div>
</div>