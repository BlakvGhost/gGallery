"use strict";

(function (global, document) {
    function MixGallery(container, elements) {
        // set up the global variables
        const _self = {};
        // array of all gallery item elements
        let _allElements = [];
        // the overall container
        const _mixGalContainer = document.createElement("div");
        _mixGalContainer.classList.add("mix-gallery");
        let _elementCount = 0;
        const _allOverlayElements = [];
        let _filteredOverlayElements = [];
        let _currOverlayElementIndex = 0;

        /*-----------------------------------------------------------*/

        // PRIVATE: create overlay element
        function _createOverlay() {
            // overlay when an element is clicked
            const overlay = document.createElement("div");
            overlay.id = "overlay";

            const prevBtn = document.createElement("button");
            const prevIcon = document.createElement("img");
            prevIcon.classList.add("prev-control-icon", "mdi", "mdi-chevron-left-circle");
            prevIcon.src = "../img/left-chevron.png";
            prevBtn.appendChild(prevIcon);

            const nextBtn = document.createElement("button");
            const nextIcon = document.createElement("img");
            nextIcon.classList.add("prev-control-icon", "mdi", "mdi-chevron-right-circle");
            nextIcon.src = "../img/right-chevron.png";
            nextBtn.appendChild(nextIcon);

            overlay.appendChild(prevBtn);
            overlay.appendChild(nextBtn);
            _addPrevControlAction(prevBtn);
            _addNextControlAction(nextBtn);
            document.body.prepend(overlay);
        }

        function _addPrevControlAction(prevBtn) {
            prevBtn.addEventListener("click", (e) => {
                _currOverlayElementIndex -= 1;
                if (_currOverlayElementIndex === -1) {
                    _currOverlayElementIndex =
                        _filteredOverlayElements.length - 1;
                }
                const prevElement = _filteredOverlayElements.filter((el) => {
                    return el.id == _currOverlayElementIndex;
                });
                _displayOverlayElement(overlay, prevElement[0]);
            });
        }

        function _addNextControlAction(nextBtn) {
            nextBtn.addEventListener("click", (e) => {
                _currOverlayElementIndex += 1;
                if (
                    _currOverlayElementIndex === _filteredOverlayElements.length
                ) {
                    _currOverlayElementIndex = 0;
                }
                const nextElement = _filteredOverlayElements.filter((el) => {
                    return el.id == _currOverlayElementIndex;
                });
                _displayOverlayElement(overlay, nextElement[0]);
            });
        }

        function _createOverlayElements(el, newEl, overlay) {
            // element
            let enlargedEl;
            if (el.type === "link") {
                enlargedEl = document.createElement("iframe");
            } else {
                enlargedEl = document.createElement(el.type);
            }
            if (el.type === "video" || el.type == "audio") {
                enlargedEl.controls = true;
            }
            enlargedEl.src = el.src;

            // container surrounding the main element
            const elContainer = document.createElement("div");
            elContainer.classList.add("overlay-element");
            elContainer.appendChild(enlargedEl);

            // title
            const overlayTitleContainer = document.createElement("div");
            overlayTitleContainer.classList.add("overlay-title");
            const overlayTitle = document.createElement("h1");
            overlayTitle.innerHTML = el.title + "  ";
            overlayTitleContainer.appendChild(overlayTitle);

            // Link
            if (el.type == "link") {
                const link = document.createElement("a");
                link.href = el.src;
                const icon = document.createElement("img");
                icon.classList.add("external-link-icon");
                icon.src = "../img/external-link-symbol.png";
                link.appendChild(icon);
                // link.innerHTML = "Click here to access the full website.";
                overlayTitle.appendChild(link);
            }

            const divider = document.createElement("hr");

            // caption
            const overlayCaption = document.createElement("h4");
            // overlayCaption.classList.add("overlay-caption");
            overlayCaption.innerHTML = el.caption;

            const overlayCaptionContainer = document.createElement("div")
            overlayCaptionContainer.classList.add("overlay-caption");
            overlayCaptionContainer.appendChild(overlayCaption);

            // container for title and caption (and link)
            const overlayText = document.createElement("div");
            overlayText.classList.add("overlay-textContainer");

            //container for controle btn area
            const newBtnEl = document.createElement("div");
            newBtnEl.classList.add("download-container");
            newBtnEl.innerHTML = `<a href='${el.src}' class='link-control fa-2x' title='Télécharger' download><i class='mdi mdi-cloud-download'></i></a> <a class='link-control fa-2x' title='Supprimer'><i class='mdi mdi-trash-can'></i></a> <a class='link-control fa-2x ' title='Editer'><i class='mdi mdi-file-edit'></i></a> <a class='link-control fa-2x info-control edit' title='Info'><i class='mdi mdi-information'></i></a>`

            //edit area
            const newEditInput = document.createElement("div");
            newEditInput.classList.add('overlayInput');
            newEditInput.innerHTML = `
            <input type='text' placeholder='Titre' value='${el.title}' class='titleEl'>
            <input type='text' placeholder='description' value='${el.caption}' class='captionEl'><button type='button' class='button'  onclick='AsyncManageElement(this,2,${el.idDb})'>SAVE</button>`

            //delete fu
            const newDelInput = document.createElement("div");
            newDelInput.classList.add('overlayInput', 'overlayDelete');
            newDelInput.innerHTML = `
            <button type='button' class='button' onclick='AsyncManageElement(this,1,${el.idDb})'>Oui</button><button type='button' data-u="ExitDel">Non</button>`

            newEditInput.addEventListener('click',(x)=>{
              if (x.target.nodeName === 'BUTTON'){
                newEditInput.classList.remove('show');
                overlayText.classList.remove('overlayAct');
              }
            })
              newDelInput.addEventListener('click',(x)=>{
                if (x.target.getAttribute('data-u') == 'ExitDel'){
                  newDelInput.classList.remove('show');
                  overlayText.classList.remove('overlayAct');
                }
            })
            newBtnEl.addEventListener('click',(x)=>{
              if (x.target.classList.contains('mdi-information')){
                newEl.webkitRequestFullScreen();
              }else if (x.target.classList.contains('mdi-file-edit')) {
                if (newEditInput.classList.contains('show')){
                  newEditInput.classList.remove('show');
                  overlayText.classList.remove('overlayAct');
                }else{
                  newDelInput.classList.remove('show')
                  newEditInput.classList.add('show');
                  overlayText.classList.add('overlayAct');
                }

              }else if (x.target.classList.contains('mdi-trash-can')) {
                if (newDelInput.classList.contains('show')){
                  newDelInput.classList.remove('show');
                  overlayText.classList.remove('overlayAct');
                }else{
                  newEditInput.classList.remove('show')
                  newDelInput.classList.add('show');
                  overlayText.classList.add('overlayAct');
                }
              }
              else {
                newEditInput.classList.remove('show');
                overlayText.classList.remove('overlayAct');
                newDelInput.classList.remove('show')
              }

            })

            overlayText.appendChild(overlayTitleContainer);
            overlayText.appendChild(divider);
            overlayText.appendChild(overlayCaptionContainer);
            overlayText.appendChild(newBtnEl);
            overlayText.appendChild(newDelInput);
            overlayText.appendChild(newEditInput);

            // container for element and textContainer
            const elTextContainer = document.createElement("div");
            elTextContainer.id = _elementCount;
            elTextContainer.classList.add("overlay-elTextContainer");
            elTextContainer.appendChild(elContainer);
            elTextContainer.appendChild(overlayText);

            _addOverlayAction(elTextContainer, newEl, overlay);
            _allOverlayElements.push(elTextContainer);
            _elementCount += 1;

        }

        // PRIVATE: event listeners for when an element is clicked and when exit
        function _addOverlayAction(elTextContainer, newEl, overlay) {
            // onClick event
            newEl.addEventListener("click", (e) => {
                overlay.classList.add("active");
                _currOverlayElementIndex = parseInt(elTextContainer.id);
                _displayOverlayElement(overlay, elTextContainer);
            });

            // Click outside of the element
            overlay.addEventListener("click", (e) => {
                if (e.target === e.currentTarget) {
                    overlay.classList.remove("active");
                }
            });
        }

        function _displayOverlayElement(overlay, elTextContainer) {
            while (overlay.firstChild.nextSibling.nextSibling) {
                overlay.removeChild(overlay.firstChild.nextSibling.nextSibling);
            }
            overlay.appendChild(elTextContainer);
        }

        // PRIVATE: create all elements and populate in _self.elements
        function _createElements(elements) {
            elements.forEach((el) => {
                // container surrounding the main element
                const newElContainer = document.createElement("div");
                newElContainer.classList.add("element");

                // main element
                let newEl;
                if (el.type === "link") {
                    newEl = document.createElement("div");
                    newEl.classList.add("iframe-cover");
                    const iframe = document.createElement("iframe");
                    iframe.src = el.src;
                    iframe.scrolling = "no";
                    newElContainer.appendChild(iframe);
                } else if (el.type === "audio") {
                    newEl = document.createElement("div");
                    newEl.classList.add("audio-cover");
                    const audio = document.createElement("audio");
                    audio.controls = true;
                    newElContainer.appendChild(audio);
                } else {
                    newEl = document.createElement(el.type);
                    newEl.src = el.src;
                }
                _createOverlayElements(el, newEl, overlay);
                newElContainer.appendChild(newEl);

                // title
                const newTitleEl = document.createElement("h2");
                newTitleEl.classList.add("title");
                newTitleEl.innerHTML = el.title;
                if (el.type === "audio") {
                    newTitleEl.classList.add("audio-title");
                }
                // button
                const newBtnEl = document.createElement("div");
                newBtnEl.classList.add("download-container");
                newBtnEl.innerHTML = `<a href='${el.src}' class='link-control fa-2x' title='Télécharger' download><i class='mdi mdi-cloud-download'></i></a> <a class='link-control fa-2x' title='Supprimer'><i class='mdi mdi-trash-can'></i></a> <a class='link-control fa-2x ' title='Editer'><i class='mdi mdi-file-edit'></i></a> <a class='link-control fa-2x info-control edit' title='Info'><i class='mdi mdi-information'></i></a>`;

                //edit area
                const newEditInput = document.createElement("div");
                newEditInput.classList.add('overlayInput');
                newEditInput.innerHTML = `
                <input type='text' placeholder='Titre' value='${el.title}' class='titleEl'>
                <input type='text' placeholder='description' value='${el.caption}' class='captionEl'><button type='button' class='button'  onclick='AsyncManageElement(this,2,${el.idDb})'>SAVE</button>`

                //delete fu
                const newDelInput = document.createElement("div");
                newDelInput.classList.add('overlayInput', 'overlayDelete');
                newDelInput.innerHTML = `
                <button type='button' class='button' onclick='AsyncManageElement(this,1,${el.idDb})'>Oui</button><button type='button' data-u="ExitDel">Non</button>`

                // container surrounding elements container and title
                const galleryItem = document.createElement("div");
                galleryItem.classList.add(
                    "gallery-item",
                    `priority-${el.priority}`
                );
                newEditInput.addEventListener('click',(x)=>{
                  if (x.target.nodeName === 'BUTTON'){
                    newEditInput.classList.remove('show');
                    galleryItem.classList.remove('galleryAct');
                  }
                })
                  newDelInput.addEventListener('click',(x)=>{
                    if (x.target.getAttribute('data-u') == 'ExitDel'){
                      newDelInput.classList.remove('show');
                      galleryItem.classList.remove('galleryAct');
                    }
                })
                newBtnEl.addEventListener('click',(x)=>{
                  if (x.target.classList.contains('mdi-information')){
                    newEl.webkitRequestFullScreen();
                  }else if (x.target.classList.contains('mdi-file-edit')) {
                    if (newEditInput.classList.contains('show')){
                      newEditInput.classList.remove('show');
                      galleryItem.classList.remove('galleryAct');
                    }else{
                      newDelInput.classList.remove('show')
                      newEditInput.classList.add('show');
                      galleryItem.classList.add('galleryAct');
                    }

                  }else if (x.target.classList.contains('mdi-trash-can')) {
                    if (newDelInput.classList.contains('show')){
                      newDelInput.classList.remove('show');
                      galleryItem.classList.remove('galleryAct');
                    }else{
                      newEditInput.classList.remove('show')
                      newDelInput.classList.add('show');
                      galleryItem.classList.add('galleryAct');
                    }
                  }
                  else {
                    newEditInput.classList.remove('show');
                    galleryItem.classList.remove('galleryAct');
                    newDelInput.classList.remove('show')
                  }

                })

                galleryItem.appendChild(newElContainer);
                galleryItem.appendChild(newTitleEl);
                galleryItem.appendChild(newBtnEl);
                galleryItem.appendChild(newEditInput);
                galleryItem.appendChild(newDelInput);

                _allElements.push(galleryItem);
            });
            _filteredOverlayElements = _allOverlayElements;

        }


        // PRIVATE: filter elements displayed based on the nav button clicked
        function _applyFilter(btn, elType, navMenu) {
            btn.addEventListener("click", (e) => {
                _destroyAllElements();
                _removeButtonActiveClass(navMenu);

                // filter _allElements array
                btn.classList.add("button-active");
                const filteredElements = _allElements.filter((el) => {
                    return el.firstChild.firstChild.tagName === elType;
                });
                _displayElements(filteredElements);

                // filter _allOverlayElements array
                const filteredOverlayElements = _allOverlayElements.filter(
                    (el) => {
                        return el.firstChild.firstChild.tagName === elType;
                    }
                );
                for (let i = 0; i < filteredOverlayElements.length; i++) {
                    filteredOverlayElements[i].setAttribute("id", i);
                }
                _changeElementIndex(filteredOverlayElements);
                _filteredOverlayElements = filteredOverlayElements;
            });
        }

        function _changeElementIndex(overlayElementsArr) {
            for (let i = 0; i < overlayElementsArr.length; i++) {
                overlayElementsArr[i].setAttribute("id", i);
            }
        }

        // PRIVATE: create navigation bar at the top
        function _createNavmenu() {
            const all = document.createElement("button");
            all.innerHTML = "All";
            all.classList.add("button-active"); // all is active by default

            const photo = document.createElement("button");
            photo.innerHTML = "Photo";

            const video = document.createElement("button");
            video.innerHTML = "Video";

            const audio = document.createElement("button");
            audio.innerHTML = "Audio";

            const link = document.createElement("button");
            link.innerHTML = "Link";

            const navMenu = document.createElement("div");
            navMenu.classList.add("nav-menu");
            navMenu.appendChild(all);
            navMenu.appendChild(photo);
            navMenu.appendChild(video);
            navMenu.appendChild(audio);
            navMenu.appendChild(link);

            // add eventlistener for filter button clicks
            all.addEventListener("click", (e) => {
                _removeButtonActiveClass(navMenu);
                all.classList.add("button-active");
                _destroyAllElements();
                _displayElements(_allElements);
                _changeElementIndex(_allOverlayElements);
                _filteredOverlayElements = _allOverlayElements;
            });
            _applyFilter(photo, "IMG", navMenu);
            _applyFilter(video, "VIDEO", navMenu);
            _applyFilter(audio, "AUDIO", navMenu);
            _applyFilter(link, "IFRAME", navMenu);

            _mixGalContainer.appendChild(navMenu);
        }

        // PRIVATE: remove "button-active" class from all navMenu buttons
        function _removeButtonActiveClass(navMenu) {
            const children = navMenu.children;
            for (let i = 0; i < children.length; i++) {
                children[i].classList.remove("button-active");
            }
        }

        // PRIVATE: display the given elements and append to the main container
        function _displayElements(elementsArr) {
            const elementsContainer = document.createElement("div");
            elementsContainer.classList.add("elements-container");
            elementsArr.forEach((el) => {
                elementsContainer.appendChild(el);
            });
            _mixGalContainer.appendChild(elementsContainer);
            container.appendChild(_mixGalContainer);
        }

        // PRIVATE: remove elements-container div from the DOM
        function _destroyAllElements() {
            const toRemove = _mixGalContainer.getElementsByClassName(
                "elements-container"
            )[0];
            if (typeof toRemove !== "undefined") {
                _mixGalContainer.removeChild(toRemove);
            }
        }

        /*-----------------------------------------------------------*/

        _self.render = () => {
            _createOverlay();
            _createNavmenu();
            _createElements(elements);
            _displayElements(_allElements);
        };

        _self.destroy = () => {
            _mixGalContainer.removeChild(_mixGalContainer.firstChild);
            _mixGalContainer.removeChild(_mixGalContainer.firstChild);
            const parent = _mixGalContainer.parentElement;
            parent.removeChild(_mixGalContainer);
            document.removeChild(document.getElementById("#overlay"));
            _allElements = [];
            _elementCount = 0;
            _allOverlayElements = [];
            _filteredOverlayElements = [];
            _currOverlayElementIndex = 0;
        };

        return _self;
    }

    global.MixGallery = global.MixGallery || MixGallery;
})(window, window.document);
