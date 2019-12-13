import WeaponBox from './components/WeaponBox.js';
import VueButton from './components/VueButton.js';

import fetchWeapon from './api/fetchWeapon.js';

// Initial setup of the store.
let weapon = {
    name: 'Patton\'s Batton',
    rarity: 'very rare',
    stats: '2d6 Bludgeoning Damage',
    lore: 'Lost during the great war.'
};

const generateWeapon = () => {
    fetchWeapon((name) => {
        weapon.name = name;
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
