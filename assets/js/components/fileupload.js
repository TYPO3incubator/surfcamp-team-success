import * as FilePond from 'filepond';
import 'filepond/dist/filepond.css';
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginImagePreview);

const file_uploads = document.querySelectorAll('input.filepond');

file_uploads.forEach(upload => {
    FilePond.create(upload);
});