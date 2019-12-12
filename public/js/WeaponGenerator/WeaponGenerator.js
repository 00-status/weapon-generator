import WeaponBox from './components/WeaponBox.js';

var app = new Vue({
    el: '#app',
    components: {
        WeaponBox
    },
    data: {
        weapon: {
            name: 'Patton\'s Batton',
            rarity: 'very rare',
            stats: '2d6 Bludgeoning Damage',
            lore: 'Lost during the great war.'
        }
    }
});
