<?php 

	class SidebarItem extends DataObject {
		
		public static $db = array(
			"Title" => "Text",
			"Content" => "HTMLText",
			"UseExternalLink" => "Boolean",
			"ExternalLink" => "Text"
			
		);
		
		public static $has_one = array (
			"Image" => "Image",
			"AssociatedPage" => "SiteTree",
		);
		
		
		public static $belongs_many_many = array (
			"Pages" => "Page"
		
		);
		
		
		public static $summary_fields = array (
			"Title",
		//	'SortOrder'
	
		);
		
		
		function getCMSFields() { 
			$fields = new FieldList(); 
			
			$fields->push( new TextField( 'Title', 'Title' ));
			//$fields->push( new TextField( 'SortOrder', 'SortOrder' ));
			$fields->push( new TreeDropdownField("AssociatedPageID", "Link to this page", "SiteTree"));
			$fields->push( new CheckboxField( 'UseExternalLink', 'Use an external link instead (below)' ));
			$fields->push( new TextField( 'ExternalLink', 'External Link' ));			
			$fields->push( new HTMLEditorField( 'Content', 'Content' ));
			$fields->push( new UploadField( 'Image', 'Image' ));
			
			$gridFieldConfig = GridFieldConfig_RelationEditor::create();
			$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		//$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
			$gridFieldConfig->addComponent(new GridFieldManyRelationHandler(), 'GridFieldPaginator');

			$gridField = new GridField("SidebarItems", "Pages that use this sidebar", $this->Pages(), $gridFieldConfig);
			
			$fields->push($gridField);


			return $fields; 
		}
		
		public function Link(){
			
			if($this->UseExternalLink){
				$link = $this->ExternalLink;
				return $link;
			}else{
				$associatedPage = $this->AssociatedPage();
				$link = $associatedPage->Link();
				return $link;
			}
			
			echo "Link: ".$link;
			
			return false;
			
		}
		
	}