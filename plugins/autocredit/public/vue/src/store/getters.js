import helpers from "../helpers";

export default {
    firstName(state) {
        if (/^[а-яё]+$/miu.test(state.name.split(' ')[0])) {
            return helpers.capitalizeFirstLetter(state.name.split(' ')[0]);
        } else {
            return ''
        }
    },
    lastName(state) {
        if (/^[а-яё]+$/miu.test(state.name.split(' ')[1])) {
            return helpers.capitalizeFirstLetter(state.name.split(' ')[1]);
        } else {
            return ''
        }
    },
    nameValid(state, getters) {
        return getters.firstName.length > 2 && getters.lastName.length > 2
    },
    phones(state) {
        return state.Data.cities[state.city].phones;
    },
    dealerships(state) {
        const filtered = state.Data.dealerships.filter((el, i) => {
            return el.city === state.city && el.brands.includes(state.brand);
        });
        return filtered.length !== 0 ? filtered : [];
    },
    personalData(state, getters) {
        return {
            firstName: getters.firstName,
            lastName: getters.lastName,
            phone: state.phone,
            email: state.email,
            passport: state.passport,
            dateBirth: state.dateBirth,
            datePassport: state.datePassport,
            city: state.Data.cities[state.city].name,
            price: state.price,
            brand: state.Data.brands[state.brand],
            age: state.carYear,
            nonce: state.Data.nonce
        }
    }
}