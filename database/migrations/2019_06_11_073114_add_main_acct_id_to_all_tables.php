<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainAcctIdToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Address_Cutomer Table
        Schema::table('address_customer', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('customer_id')->unsigned();
        });

        //Billings
        Schema::table('billings', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('invoice')->unsigned();
        });

        //Address
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('name')->unsigned();
        });

        //
        // Schema::table('category_product', function (Blueprint $table) {
        //     $table->integer('main_acct_id')->after('category_id')->unsigned();
        // });
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('email')->unsigned();
        });

        //
        Schema::table('contact_customer', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('email')->unsigned();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('account_id')->unsigned();
        });

        //
        Schema::table('customer_corporates', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('employee_count')->unsigned();
        });
        Schema::table('customer_individuals', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('home_address')->unsigned();
        });

        //
        Schema::table('customer_invoice', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('invoice_id')->unsigned();
        });
        Schema::table('customer_renewal', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('renewal_id')->unsigned();
        });

        //
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('type')->unsigned();
        });
        Schema::table('opportunities', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('contact')->unsigned();
        });

        //
        // Schema::table('opportunity_product', function (Blueprint $table) {
        //     $table->integer('main_acct_id')->after('product_price')->unsigned();
        // });
        Schema::table('password_resets', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('token')->unsigned();
        });

        //
        // Schema::table('payables', function (Blueprint $table) {
        //     $table->integer('main_acct_id')->after('payable_id')->unsigned();
        // });
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('outstanding')->unsigned();
        });

        //
        // Schema::table('payment_product', function (Blueprint $table) {
        //     $table->integer('main_acct_id')->after('product_id')->unsigned();
        // });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('sub_category_id')->unsigned();
        });

        //
        Schema::table('product_sub_categories', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('sub_category_id')->unsigned();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('end_date')->unsigned();
        });

        // 
        Schema::table('renewals', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('customer_id')->unsigned();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('location_id')->unsigned();
        });

        //
        Schema::table('sales_location', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('location')->unsigned();
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('name')->unsigned();
        });

        //
        Schema::table('targets', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('product_id')->unsigned();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('name')->unsigned();
        });
        // Schema::table('users', function (Blueprint $table) {
        //     $table->integer('main_acct_id')->after('role_id')->unsigned();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address_customer', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //Billings
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //Address
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        // Schema::table('category_product', function (Blueprint $table) {
        //     $table->dropColumn('main_acct_id');
        // });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('contact_customer', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('customer_corporates', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('customer_individuals', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('customer_invoice', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('customer_renewal', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        // Schema::table('opportunity_product', function (Blueprint $table) {
        //     $table->dropColumn('main_acct_id');
        // });
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        // Schema::table('payables', function (Blueprint $table) {
        //     $table->dropColumn('main_acct_id');
        // });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        // Schema::table('payment_product', function (Blueprint $table) {
        //     $table->dropColumn('main_acct_id');
        // });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('product_sub_categories', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('renewals', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        //
        Schema::table('sales_location', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });

        //
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('main_acct_id');
        // });
    }
}
