import * as FilePond from 'filepond';
import 'filepond/dist/filepond.css';
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

const input_elements = document.querySelectorAll('input.filepond');
initFilepond(input_elements)

document.addEventListener("openmodal", () => {
    const modal_input_elements = document.querySelectorAll('.modal input.filepond');
    initFilepond(modal_input_elements);
});

function initFilepond(elements) {
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize,
        FilePondPluginImagePreview
    );
    
    elements.forEach(upload => {
        FilePond.create(upload);
    });
}