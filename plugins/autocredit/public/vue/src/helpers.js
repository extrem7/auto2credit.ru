export default {
    validateFields($fields) {
        let valid = true;
        const stopPhones = ['+7 (111) 111-11-11', '+7 (222) 222-22-22', '+7 (333) 333-33-33', '+7 (444) 444-44-44',
            '+7 (555) 555-55-55', '+7 (666) 666-66-66', '+7 (777) 777-77-77', '+7 (888) 888-88-88', '+7 (999) 999-99-99',
            '+7 (000) 000-00-00'];
        $fields.each(function () {
            let $parent = $(this).closest('.form-group'),
                fakePhone = $(this).prop('type') === 'tel' && stopPhones.includes($(this).val());
            if (!$(this)[0].validity.valid || fakePhone) {
                $parent.addClass('error');
                valid = false;
            } else {
                $parent.removeClass('error');
            }
        });
        return valid;
    },
    scrollTop(offset = 0) {
        if (window.innerWidth < 992) {
            $("html, body").animate({scrollTop: offset}, "slow");
        }
    },
    capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    },
    formatLocale(value) {
        value += "";
        const val = value.replace(/ /g, '');
        return parseFloat(val).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 0,
            minimumFractionDigits: 0
        }).replace(/,/g, ' ');
    },
    parseLocale(value) {
        return value !== '' ? Math.abs(parseInt(value.replace(/ /g, ''))) : 0;
    },
    annuity(sum, duration, rate, reverse = false) {
        rate = (rate / 12) / 100;
        duration = duration / 12;
        let q = (rate * (Math.pow(1 + rate, duration * 12))) / (Math.pow(1 + rate, duration * 12) - 1);
        return reverse ? sum / q : sum * q;
    }
}