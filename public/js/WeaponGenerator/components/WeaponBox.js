
const weaponBox = `
<div class="weaponBox">
    <h1>{{ title }}</h1>
    <h3><slot name="sub-title"></slot></h3>
    <div><slot name="content"></slot></div>
    <div><slot name="sub-content"></slot></div>
    <div><slot name="side-bar"></slot></div>
</div>`;
const WeaponBox = {props: {title: String}, template: weaponBox}

export default WeaponBox;
