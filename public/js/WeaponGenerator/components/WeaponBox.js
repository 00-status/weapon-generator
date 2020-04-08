
const weaponBox = `
<div class="weaponBox">
    <h1>{{ title }}</h1>
    <div class="divider"></div>
    <h3><slot name="sub-title"></slot></h3>
    <div><slot name="content"></slot></div>
    <div class="divider"></div>
    <ul class="effectList">
        <li v-for="effect in effects">
            {{ effect }}
        </li>
    </ul>
</div>`;
const WeaponBox = {props: {title: String, effects: Array}, template: weaponBox}

export default WeaponBox;
