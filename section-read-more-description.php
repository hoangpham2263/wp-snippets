	<div class="container px-4 mx-auto my-7.5 lg:my-15 entry-post-content relative">
		<input type="checkbox" name="" id="product-categery-description-toggle" class="hidden">
		<div id="product-category-description">
			<?php
			$term = get_queried_object();
			if ($term && isset($term->description) && !empty($term->description)) {
				echo term_description($term->term_id, $term->taxonomy);
			}
			?>
		</div>
		<div id="product-category-read-more-button" class="absolute z-10 bottom-0 left-0 right-0 flex flex-col">
			<div class="w-full aspect-[1380/147] bg-[linear-gradient(180deg,rgba(255,255,255,0)_0%,#FFFFFF_100%)]"></div>
			<div class="w-full pt-5 bg-white">
				<label for="product-categery-description-toggle" class="w-fit mx-auto flex items-center gap-x-2 hover:text-secondary group cursor-pointer">
					Xem thêm
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path class="group-hover:stroke-secondary" d="M4 7L10 13L16 7" stroke="#131313" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</label>
			</div>
		</div>

		<div id="product-category-collapse-button" class="pt-5">
			<label for="product-categery-description-toggle" class="w-fit mx-auto flex items-center gap-x-2 hover:text-secondary group cursor-pointer">
				Thu gọn
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path class="group-hover:stroke-secondary" d="M16 13L10 7L4 13" stroke="#131313" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</label>
		</div>

		<style>
			#product-category-description {
				max-height: 300px;
				overflow: hidden;
				transition: max-height 0.3s ease;
			}

			#product-categery-description-toggle:checked~#product-category-description {
				max-height: none !important;
			}

			#product-categery-description-toggle:checked~#product-category-read-more-button {
				display: none;
			}

			#product-categery-description-toggle:not(:checked)~#product-category-collapse-button {
				display: none;
			}
		</style>
	</div>