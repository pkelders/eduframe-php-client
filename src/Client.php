<?php

namespace Eduframe;

use Eduframe\Resources\Account;
use Eduframe\Resources\Address;
use Eduframe\Resources\Category;
use Eduframe\Resources\Course;
use Eduframe\Resources\CourseTabContent;
use Eduframe\Resources\CourseTab;
use Eduframe\Resources\Edition;
use Eduframe\Resources\Enrollment;
use Eduframe\Resources\Label;
use Eduframe\Resources\Lead;
use Eduframe\Resources\LeadInterest;
use Eduframe\Resources\Location;
use Eduframe\Resources\Meeting;
use Eduframe\Resources\Variant;
use Eduframe\Resources\Order;
use Eduframe\Resources\PaymentMethod;
use Eduframe\Resources\PaymentOption;
use Eduframe\Resources\PlannedCourse;
use Eduframe\Resources\Program;
use Eduframe\Resources\Referral;
use Eduframe\Resources\SignupQuestion;
use Eduframe\Resources\Teacher;
use Eduframe\Resources\CatalogProduct;
use Eduframe\Resources\CatalogVariant;
use Eduframe\Resources\Invoice;
use Eduframe\Resources\InvoiceItem;


/**
 * Class Eduframe
 * @package Eduframe
 */
class Client {
	/**
	 * The HTTP connection
	 * @var \Eduframe\Connection
	 */
	protected $connection;

	/**
	 * Eduframe constructor.
	 * @param \Eduframe\Connection $connection
	 */
	public function __construct( $connection ) {
		$this->connection = $connection;
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Account
	 */
	public function accounts( $attributes = [] ) {
		return new Account( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Address
	 */
	public function addresses( $attributes = [] ) {
		return new Address( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Category
	 */
	public function categories( $attributes = [] ) {
		return new Category( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Course
	 */
	public function courses( $attributes = [] ) {
		return new Course( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Program
	 */
	public function programs( $attributes = [] ) {
		return new Program( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 *
	 * @return \Eduframe\Resources\Location
	 */
	public function course_locations( $attributes = [] ) {
		return new Location( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 *
	 * @return \Eduframe\Resources\Variant
	 */
	public function course_variants( $attributes = [] ) {
		return new Variant( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Edition
	 */
	public function editions( $attributes = [] ) {
		return new Edition( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Enrollment
	 */
	public function enrollments( $attributes = [] ) {
		return new Enrollment( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Label
	 */
	public function labels( $attributes = [] ) {
		return new Label( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Lead
	 */
	public function leads( $attributes = [] ) {
		return new Lead( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\LeadInterest
	 */
	public function lead_interests( $attributes = [] ) {
		return new LeadInterest( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Meeting
	 */
	public function meetings( $attributes = [] ) {
		return new Meeting( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Order
	 */
	public function orders( $attributes = [] ) {
		return new Order( $this->connection, $attributes );
	}
    /**
     * @param array $attributes
     * @return \Eduframe\Resources\Invoice
     */
    public function invoices( $attributes = [] ) {
        return new Invoice( $this->connection, $attributes );
    }

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\PaymentMethod
	 */
	public function payment_methods( $attributes = [] ) {
		return new PaymentMethod( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\PaymentOption
	 */
	public function payment_options( $attributes = [] ) {
		return new PaymentOption( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\PlannedCourse
	 */
	public function planned_courses( $attributes = [] ) {
		return new PlannedCourse( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Referral
	 */
	public function referrals( $attributes = [] ) {
		return new Referral( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\SignupQuestion
	 */
	public function signup_questions( $attributes = [] ) {
		return new SignupQuestion( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\Teacher
	 */
	public function teachers( $attributes = [] ) {
		return new Teacher( $this->connection, $attributes );
	}
    /**
     * @param array $attributes
     * @return \Eduframe\Resources\CourseTabContent
     */
    public function courseTabContents( $attributes = [] ) {
        return new CourseTabContent( $this->connection, $attributes );
    }
    /**
     * @param array $attributes
     * @return \Eduframe\Resources\CourseTab
     */
    public function courseTab( $attributes = [] ) {
        return new CourseTab( $this->connection, $attributes );
    }
	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\CatalogProduct
	 */
	public function catalog_products( array $attributes = [] ): CatalogProduct {
		return new CatalogProduct( $this->connection, $attributes );
	}

	/**
	 * @param array $attributes
	 * @return \Eduframe\Resources\CatalogVariant
	 */
	public function catalog_variants( array $attributes = [] ): CatalogVariant {
		return new CatalogVariant( $this->connection, $attributes );
	}

	/**
	 * @return \Eduframe\Connection
	 */
	public function getConnection() {
		return $this->connection;
	}
}
