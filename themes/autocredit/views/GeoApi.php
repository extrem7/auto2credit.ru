<? global $Auto2Credit ?>
<div class="modal fade" id="geoapi">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <? require get_template_directory() . "/assets/img/icons/times.svg" ?>
            </button>
            <div class="modal-body">
                <div class="sub-title mb-2 text-center">Выберите свой город</div>
                <form method="post">
                    <select name="city-name" class="control-form custom-select">
                        <option selected disabled><?= $Auto2Credit->geo->city->name ?></option>
                        <? foreach ($Auto2Credit->geo->getList() as $city): ?>
                            <option value="<? the_field('slug', $city) ?>"><?= $city->name ?></option>
                        <? endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>