<script>
	$(document).ready(function(){
		var count = 1;
		$(".file_name").each(function(){
			var base_url = $('#base').val();
			var file_name = $(this).val();
			var folder = $('#nama_kategori').val();
			var url = base_url + 'data_uploads/'+folder+'/'+file_name;
			var canvas_name = 'the-canvas'+count;

			var pdfDoc = null,
			pageNum = 1,
			pageRendering = false,
			pageNumPending = null,
			scale = 1.5,
			zoomRange = 0.25,
			canvas = document.getElementById(canvas_name),
			ctx = canvas.getContext('2d');
				/**
				 * Get page info from document, resize canvas accordingly, and render page.
				 * @param num Page number.
				 */
				 function renderPage(num, scale) {
				 	pageRendering = true;
					// Using promise to fetch the page
					pdfDoc.getPage(num).then(function(page) {
						var viewport = page.getViewport(scale);
						canvas.height = viewport.height;
						canvas.width = viewport.width;

						// Render PDF page into canvas context
						var renderContext = {
							canvasContext: ctx,
							viewport: viewport
						};
						var renderTask = page.render(renderContext);

						// Wait for rendering to finish
						renderTask.promise.then(function () {
							pageRendering = false;
							if (pageNumPending !== null) {
								// New page rendering is pending
								renderPage(pageNumPending);
								pageNumPending = null;
							}
						});
					});

					// Update page counters
					var page_num = 'page_num'+count;
					document.getElementById(page_num).value = num;
				}

				/**
				 * If another page rendering in progress, waits until the rendering is
				 * finised. Otherwise, executes rendering immediately.
				 */
				 function queueRenderPage(num) {
				 	if (pageRendering) {
				 		pageNumPending = num;
				 	} else {
				 		renderPage(num,scale);
				 	}
				 }

				/**
				 * Displays previous page.
				 */
				 function onPrevPage() {
				 	if (pageNum <= 1) {
				 		return;
				 	}
				 	pageNum--;
				 	var scale = pdfDoc.scale;
				 	queueRenderPage(pageNum, scale);
				 }
				 var prev = 'prev'+count;
				 document.getElementById(prev).addEventListener('click', onPrevPage);

				/**
				 * Displays next page.
				 */
				 function onNextPage() {
				 	if (pageNum >= pdfDoc.numPages) {
				 		return;
				 	}
				 	pageNum++;
				 	var scale = pdfDoc.scale;
				 	queueRenderPage(pageNum, scale);
				 }
				 var next = 'next'+count;
				 alert(next);
				 document.getElementById(next).addEventListener('click', onNextPage);

				/**
				 * Zoom in page.
				 */
				 function onZoomIn() {
				 	if (scale >= pdfDoc.scale) {
				 		return;
				 	}
				 	scale += zoomRange;
				 	var num = pageNum;
				 	renderPage(num, scale)
				 }
				 var zoomin = 'zoomin'+count;
				 document.getElementById(zoomin).addEventListener('click', onZoomIn);

				/**
				 * Zoom out page.
				 */
				 function onZoomOut() {
				 	if (scale >= pdfDoc.scale) {
				 		return;
				 	}
				 	scale -= zoomRange;
				 	var num = pageNum;
				 	queueRenderPage(num, scale);
				 }
				 var zoomout = 'zoomout'+count;
				 document.getElementById(zoomout).addEventListener('click', onZoomOut);

				/**
				 * Zoom fit page.
				 */
				 function onZoomFit() {
				 	if (scale >= pdfDoc.scale) {
				 		return;
				 	}
				 	scale = 1;
				 	var num = pageNum;
				 	queueRenderPage(num, scale);
				 }
				 var zoomfit = 'zoomfit'+count;
				 document.getElementById(zoomfit).addEventListener('click', onZoomFit);


				/**
				 * Asynchronously downloads PDF.
				 */
				 PDFJS.getDocument(url).then(function (pdfDoc_) {
				 	pdfDoc = pdfDoc_;
				 	var documentPagesNumber = pdfDoc.numPages;
				 	var page_count = 'page_count'+count;
				 	document.getElementById(page_count).textContent = '/ ' + documentPagesNumber;

				 	$('#page_num').on('change', function() {
				 		var pageNumber = Number($(this).val());

				 		if(pageNumber > 0 && pageNumber <= documentPagesNumber) {
				 			queueRenderPage(pageNumber, scale);
				 		}

				 	});

					// Initial/first page rendering
					renderPage(pageNum, scale);
				});
				 count++;

				});
			});

</script>