window.onload = function() {
    if(CountAttachment > 0) {
        document.getElementById("countFile").innerText = `Selected ${CountAttachment} files`;
    }else {
        document.getElementById("countFile").innerText = `Drop the file here or click to browse and select the file.`;
    }

    AttachmentsName = AttachmentsName.split(',');
    let tmp = "";
    AttachmentsName.forEach(item => {
        tmp += `<div class="files-list"> 
                    <span>${item}</span>
                </div>`;
    });
    document.getElementById("displayFile").innerHTML = tmp;
}

function displayFilesList(files) {
    let tmp = "";
    let names = "";
    for(let i=0; i<=files.length; i++) {
        if(files[i]){
            tmp += `<div class="files-list"> 
                        <span>${files[i].name}</span>
                    </div>`;
            names += `${files[i].name},`;
        }
    }
    // console.log(tmp);
    document.getElementById("countFile").innerText = `Selected ${files.length} files`;
    document.getElementById("displayFile").innerHTML = tmp;
    document.getElementById("plugin_asset_tempName").value = names;
} 
function getAllFile() {
    let files = document.getElementById("groupFile").files;
    // console.log(files);
    displayFilesList(files);
}