const vueButton = `
<button v-on:click="listener">
    Generate Weapon
</button>
`;
const VueButton = {props: {listener: Function}, template: vueButton};

export default VueButton;
