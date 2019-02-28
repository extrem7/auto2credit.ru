<template>
    <div class="offset-lg-4 col-lg-4 col-md-12">
        <div class="form-group confirm">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="accept" class="custom-control-input accept"
                       id="customCheck4" checked="checked" required>
                <label class="custom-control-label accept" for="customCheck4">Даю <a
                        :href="$store.state.Data.politic" target="_blank">согласие
                    на обработку моих персональных данных</a></label>
            </div>
        </div>
    </div>
</template>