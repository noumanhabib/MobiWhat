function ajaxRequest(url, success, method = "GET", data = {}) {
    var xhr = $.ajax({
        url: url,
        method: method,
        headers: {
            Auth: "0&Uu^U@%pjSqd,tHof0oI3g^>uTyI~",
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer YtLlDhn313P35K5Hkh0oHNIuMjXPQg0i"
            );
        },
        data: data,
        error: function (xhr, status, error) {
            console.log(
                "Some error occured Status : " +
                    status +
                    " and Error String : " +
                    error.toString()
            );
        },
    })
        .done(success)
        .fail(function () {
            console.log("Some error occured");
        });

    return xhr;
}

function createMobileDiv(mobile, brand) {
    let mobileDiv = document.createElement("div");
    mobileDiv.classList.add("mobile-card");

    let network = "1G";
    if (mobile["4g"]) {
        network = "4G LTE";
    } else if (mobile["3g"]) {
        network = "3G";
    } else if (mobile["2g"]) {
        network = "2G";
    }

    mobileDiv.innerHTML = `
        <img src="/storage${mobile.cover}" alt="Mobile image">
        <div class="mobile-card-body">
            <p class="title">${mobile.name}</p>
            <p class="brand text-capitalize">${brand}</p>
            <p class="price">${mobile.price} PKR</p>
            <p class="mobile-specs">
                <span class="badge badge-primary">${mobile.ram}GB Ram</span>
                <span class="badge badge-dark">${mobile.storage}GB Storage</span>
                <span class="badge badge-success">${mobile.battery_capacity} mah Battery</span>
            </p>
        </div>
        <div class="mobile-right-specs">
            <div class="expand-icon">
                <i class="far fa-heart pr-3 fav-icon-i"></i>
                <i class="fa fa-expand"></i>
            </div>
            <span class="badge badge-info">${mobile.os}</span>
            <br />
            ${network}
            <br />
            ${mobile.screen_size}" Display <br />
            ${mobile.camera_main}MP Back Camera <br />
            ${mobile.camera_front}MP Front Camera
        </div>
        <a href="/mobile/${mobile.id}" class="overlay"></a>
        <input type="hidden" value="${mobile.id}" class="forMobileId">
    `;

    let icon = mobileDiv.querySelector("i.fav-icon-i");
    if (favList.includes(mobile.id)) {
        icon.classList.remove("far");
        icon.classList.add("fa");
    }
    icon.addEventListener("click", (e) => {
        if (favList.includes(mobile.id)) {
            icon.classList.remove("fa");
            icon.classList.add("far");
            removeFromFav(mobile.id);
            $("#fav-added")[0].innerText = favList.length;
        } else {
            icon.classList.remove("far");
            icon.classList.add("fa");
            addToFav(mobile.id);
            $("#fav-added")[0].innerText = favList.length;
        }
    });

    return mobileDiv;
}

function updateTopMobile(mobiles, type, brand = "") {
    $(type)[0].innerHTML = "";
    mobiles.forEach((mobile) => {
        if (type === "#top-year") {
            brand = mobile.brand_name;
        }
        $(type)[0].appendChild(createMobileDiv(mobile, brand));
    });
}

function createBrandDiv(brand) {
    const brandDiv = document.createElement("div");
    brandDiv.classList.add("brand-item");
    brandDiv.innerHTML = `
        <a href="/brand/${brand}" target="_blank" alt="Brand:Mobiles" rel="noopener noreferrer" class="text-capitalize"> ${brand} </a>
    `;
    return brandDiv;
}

function updateBrandList(brands, selector) {
    $(selector)[0].innerHTML = "";
    brands.forEach((brand) => {
        $(selector)[0].appendChild(createBrandDiv(brand));
    });
}

function requestHints(query, selector) {
    const url = "http://localhost:8000/api/search_hints";
    const inputDiv = document.getElementById("search-bar-input");
    ajaxRequest(
        url,
        function (data) {
            let dataArray = JSON.parse(data);
            if (dataArray.length < 1) {
                return;
            }
            $(selector)[0].innerHTML = "";
            dataArray.forEach((v) => {
                let span = document.createElement("span");
                span.innerText = v.name;
                $(selector)[0].appendChild(span);

                span.addEventListener("click", (e) => {
                    inputDiv.value = span.innerText;
                });
            });
        },
        "GET",
        { query }
    );
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        let posOf = c.indexOf(name, 0);
        if (posOf != -1) {
            return c.substr(posOf + name.length);
        }
    }
    return null;
}

//Making any mobile component filled heart if in fav-list
const allMobiles = document.querySelectorAll(".mobile-list");
var fav = getCookie("fav");
var favList = fav ? JSON.parse(fav) : [];
allMobiles.forEach((m) => {
    let mobile_id = parseInt(m.querySelector("input.forMobileId").value);
    let icon = m.querySelector("i.fav-icon-i");
    if (favList.includes(mobile_id)) {
        icon.classList.remove("far");
        icon.classList.add("fa");
    }
    icon.addEventListener("click", (e) => {
        if (favList.includes(mobile_id)) {
            icon.classList.remove("fa");
            icon.classList.add("far");
            removeFromFav(mobile_id);
            $("#fav-added")[0].innerText = favList.length;
        } else {
            icon.classList.remove("far");
            icon.classList.add("fa");
            addToFav(mobile_id);
            $("#fav-added")[0].innerText = favList.length;
        }
    });
});

//Changing navbar fav number value Default->0
$("#fav-added")[0].innerText = favList.length;

//Creating fav table rows
function createFavRow(mobile, i) {
    let row = document.createElement("tr");
    row.innerHTML = `
        <td>${i}</td>
        <td>${mobile.name}</td>
        <td class="text-capitalize">${mobile.brand_name}</td>
        <td>
            <img src="/storage${mobile.cover}" width="50" alt="">
        </td>
        <td>
            <button data-id="${mobile.id}" class="btn btn-trash-rm"><i class="fas fa-trash"></i></button>
        </td>
    `;
    return row;
}

function addToFav(mobile_id) {
    if (favList.length < 1) {
        setCookie("fav", "[" + mobile_id + "]", 100);
        favList.push(mobile_id);
    } else {
        if (!favList.includes(mobile_id)) {
            favList.push(mobile_id);
            setCookie("fav", JSON.stringify(favList), 100);
        }
    }
}

function removeFromFav(mobile_id) {
    if (favList.includes(mobile_id)) {
        favList = favList.filter((i) => {
            return i != mobile_id;
        });
        setCookie("fav", JSON.stringify(favList), 100);
    }
}

var comp = getCookie("comp");
var compList = comp ? JSON.parse(comp) : [];
$("#comp-added")[0].innerText = compList.length;

function addToComp(mobile_id) {
    if (compList.length < 1) {
        setCookie("comp", "[" + mobile_id + "]", 100);
        compList.push(mobile_id);
    } else {
        if (!compList.includes(mobile_id)) {
            compList.push(mobile_id);
            setCookie("comp", JSON.stringify(compList), 100);
        }
    }
    $("#comp-added")[0].innerText = compList.length;
}

function removeFromComp(mobile_id) {
    if (compList.includes(mobile_id)) {
        compList = compList.filter((i) => {
            return i != mobile_id;
        });
        setCookie("comp", JSON.stringify(compList), 100);
    }
    $("#comp-added")[0].innerText = compList.length;
}

//Creating comparison table rows
function createCompRow(mobile, i) {
    let row = document.createElement("tr");
    row.innerHTML = `
        <td>${i}</td>
        <td>${mobile.name}</td>
        <td class="text-capitalize">${mobile.brand_name}</td>
        <td>
            <img src="/storage${mobile.cover}" width="50" alt="">
        </td>
        <td>
            <button data-id="${mobile.id}" class="btn btn-trash-rm"><i class="fas fa-trash"></i></button>
        </td>
    `;
    return row;
}
