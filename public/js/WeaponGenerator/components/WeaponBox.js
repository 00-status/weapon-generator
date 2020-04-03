
const weaponBox = `
<div class="weaponBox">
    <h1>{{ title }}</h1>
    <h3><slot name="sub-title"></slot></h3>
    <div><slot name="content"></slot></div>
    <ul v-for="effect in effects">
        <li>{{ effect }}</li>
    </ul>
</div>`;
const WeaponBox = {props: {title: String, effects: Array}, template: weaponBox}

export default WeaponBox;
