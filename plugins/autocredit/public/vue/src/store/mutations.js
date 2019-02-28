import Vue from "vue"
import * as types from './mutation-types'

export default {
    UPDATE_NAME(state, name) {
        state.name = name;
        Vue.ls.set('name', name);
    },
    UPDATE_PHONE(state, phone) {
        state.phone = phone;
        Vue.ls.set('phone', phone);
    },
    UPDATE_EMAIL(state, email) {
        state.email = email;
        Vue.ls.set('email', email);
    },
    UPDATE_BRAND(state, brand) {
        brand = parseInt(brand);
        state.brand = brand;
        Vue.ls.set('brand', brand);
    },
    UPDATE_CAR_YEAR(state, year) {
        state.carYear = year;
        Vue.ls.set('carYear', year);
    },
    UPDATE_CITY(state, city) {
        city = parseInt(city);
        state.city = city;
        Vue.ls.set('city', city);
    },
    UPDATE_PASSPORT(state, passport) {
        state.passport = passport;
        Vue.ls.set('passport', passport);
    },
    UPDATE_DATE_BIRTH(state, date) {
        state.dateBirth = date;
        Vue.ls.set('dateBirth', date);
    },
    UPDATE_DATE_DEAL(state, date) {
        state.dateDeal = date;
        Vue.ls.set('dateDeal', date);
    },
    UPDATE_DATE_PASSPORT(state, date) {
        state.datePassport = date;
        Vue.ls.set('datePassport', date);
    },
    UPDATE_PRICE(state, price) {
        state.price = price;
        Vue.ls.set('price', price);
    },
    UPDATE_DEALERSHIP(state, dealership) {
        state.dealership = dealership;
    },
    UPDATE_INTERVAL(state, interval) {
        state.interval = interval;
        Vue.ls.set('interval', interval);
    }
}