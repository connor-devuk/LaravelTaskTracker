import './bootstrap';

import Alpine from 'alpinejs';


window.Alpine = Alpine;

Alpine.start();

document.getElementById("selectOptions").addEventListener("change", function() {
    const select = this;
    const option = select.options[select.selectedIndex];

    // If the selected option is empty or not found in the dropdown, prompt to create a new option
    if (!option || option.value === "") {
        const newOption = prompt("Enter a new option:");
        if (newOption !== null && newOption.trim() !== "") {
            const newOptionElement = document.createElement("option");
            newOptionElement.value = newOption;
            newOptionElement.textContent = newOption;
            select.appendChild(newOptionElement);
            select.value = newOption;
        } else {
            // If the user cancels or enters an empty value, revert back to the default value
            select.value = "";
        }
    }
});

