/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 groceryee app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AdminComponent } from './layouts/admin/admin.component';
import { AuthComponent } from './layouts/auth/auth.component';
import { AuthGuard } from './guard/auth.guard';
import { SetupAuthGuard } from './setupGuard/auth.guard';
import { LeaveGuard } from './leaved/leaved.guard';

const routes: Routes = [
  {
    path: '',
    component: AdminComponent,
    children: [
      {
        path: '',
        redirectTo: 'dashboard',
        pathMatch: 'full'
      },
      {
        path: 'dashboard',
        loadChildren: () => import('./pages/dashboard/dashboard.module').then(m => m.DashboardModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'city',
        loadChildren: () => import('./pages/cities/cities.module').then(m => m.CitiesModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'users',
        loadChildren: () => import('./pages/users/users.module').then(m => m.UsersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'stores',
        loadChildren: () => import('./pages/stores/stores.module').then(m => m.StoresModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'orders',
        loadChildren: () => import('./pages/orders/orders.module').then(m => m.OrdersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'drivers',
        loadChildren: () => import('./pages/drivers/drivers.module').then(m => m.DriversModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'offers',
        loadChildren: () => import('./pages/offers/offers.module').then(m => m.OffersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'banners',
        loadChildren: () => import('./pages/banners/banners.module').then(m => m.BannersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'contacts',
        loadChildren: () => import('./pages/contacts/contacts.module').then(m => m.ContactsModule),
        canDeactivate: [LeaveGuard]
      },
      {
        path: 'notifications',
        loadChildren: () => import('./pages/notifications/notifications.module').then(m => m.NotificationsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'stats',
        loadChildren: () => import('./pages/stats/stats.module').then(m => m.StatsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-users',
        loadChildren: () => import('./pages/manage-users/manage-users.module').then(m => m.ManageUsersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-stores',
        loadChildren: () => import('./pages/manage-stores/manage-stores.module').then(m => m.ManageStoresModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-orders',
        loadChildren: () => import('./pages/manage-orders/manage-orders.module').then(m => m.ManageOrdersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-drivers',
        loadChildren: () => import('./pages/manage-drivers/manage-drivers.module').then(m => m.ManageDriversModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-offers',
        loadChildren: () => import('./pages/manage-offers/manage-offers.module').then(m => m.ManageOffersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-banners',
        loadChildren: () => import('./pages/manage-banners/manage-banners.module').then(m => m.ManageBannersModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-city',
        loadChildren: () => import('./pages/manage-city/manage-city.module').then(m => m.ManageCityModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'category',
        loadChildren: () => import('./pages/category/category.module').then(m => m.CategoryModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'sub-category',
        loadChildren: () => import('./pages/sub-category/sub-category.module').then(m => m.SubCategoryModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-category',
        loadChildren: () => import('./pages/manage-category/manage-category.module').then(m => m.ManageCategoryModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-sub-category',
        loadChildren: () => import('./pages/manage-sub-category/manage-sub-category.module').then(m => m.ManageSubCategoryModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'languages',
        loadChildren: () => import('./pages/languages/languages.module').then(m => m.LanguagesModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-languages',
        loadChildren: () => import('./pages/manage-languages/manage-languages.module').then(m => m.ManageLanguagesModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-app',
        loadChildren: () => import('./pages/manage-app/manage-app.module').then(m => m.ManageAppModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'send-mail',
        loadChildren: () => import('./pages/send-email/send-email.module').then(m => m.SendEmailModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'app-settings',
        loadChildren: () => import('./pages/app-settings/app-settings.module').then(m => m.AppSettingsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'general',
        loadChildren: () => import('./pages/app-web/app-web.module').then(m => m.AppWebModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'products',
        loadChildren: () => import('./pages/products/products.module').then(m => m.ProductsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-products',
        loadChildren: () => import('./pages/manage-products/manage-products.module').then(m => m.ManageProductsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'payment',
        loadChildren: () => import('./pages/payments/payments.module').then(m => m.PaymentsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-payment',
        loadChildren: () => import('./pages/manage-payment/manage-payment.module').then(m => m.ManagePaymentModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'app-pages',
        loadChildren: () => import('./pages/app-pages/app-pages.module').then(m => m.AppPagesModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-app-pages',
        loadChildren: () => import('./pages/manage-app-pages/manage-app-pages.module').then(m => m.ManageAppPagesModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'driver-stats',
        loadChildren: () => import('./pages/driver-stats/driver-stats.module').then(m => m.DriverStatsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'emails',
        loadChildren: () => import('./pages/emails/emails.module').then(m => m.EmailsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'emails-details',
        loadChildren: () => import('./pages/emails-details/emails-details.module').then(m => m.EmailsDetailsModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-popup',
        loadChildren: () => import('./pages/manage-popup/manage-popup.module').then(m => m.ManagePopupModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'administrantor',
        loadChildren: () => import('./pages/administrator/administrator.module').then(m => m.AdministratorModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-administrantor',
        loadChildren: () => import('./pages/manage-admin/manage-admin.module').then(m => m.ManageAdminModule),
        canActivate: [AuthGuard]
      },
      {
        path: 'manage-website',
        loadChildren: () => import('./pages/manage-website/manage-website.module').then(m => m.ManageWebsiteModule),
        canActivate: [AuthGuard]
      }
      //
    ]
  },
  {
    path: '',
    component: AuthComponent,
    children: [
      {
        path: 'login',
        loadChildren: () => import('./pages/login/login.module').then(m => m.LoginModule),
        canActivate: [SetupAuthGuard]
      },
      // , {
      //   path: 'report',
      //   loadChildren: () => import('./reports/reports.module').then(m => m.ReportsModule)
      // },
      {
        path: 'setup',
        loadChildren: () => import('./pages/setup/setup.module').then(m => m.SetupModule)
      },
    ]
  },
  {
    path: '**',
    redirectTo: 'dashboard'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
