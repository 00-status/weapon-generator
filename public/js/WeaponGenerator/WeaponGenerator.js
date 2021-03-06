import WeaponBox from './components/WeaponBox.js';
import VueButton from './components/VueButton.js';

import fetchWeapon from './api/fetchWeapon.js';

// Initial setup of the store.
let weapon = {
    name: '',
    rarity: '',
    damageType: '',
    damageDie: 6,
    damageDieAmount: 2,
    effects: []
};

const generateWeapon = () => {
    fetchWeapon((response) => {
        weapon.name = response.name;
        weapon.rarity = response.rarity;
        weapon.damageType = response.damage_type;
        weapon.damageDie = response.damage_die;
        weapon.damageDieAmount = response.damage_die_amount;
        weapon.effects = response.effects;
    });
};

// Grab an initial weapon.
generateWeapon();

var app = new Vue({
    el: '#app',
    components: { // Reusable building blocks that make up our page.
        WeaponBox,
        VueButton
    },
    methods: {
        generateWeapon: generateWeapon
    },
    data: { // Data that our components will use.
        weapon
    }
});
