import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { ApisService } from '../services/apis.service';

@Injectable({
    providedIn: 'root'
})
export class AuthGuard implements CanActivate {

    constructor(private api: ApisService, private router: Router) { }

    canActivate(): Observable<boolean> | Promise<boolean> | boolean {
        return new Promise(res => {


            this.api.post_private('users/validateStoreToken', {}).then(
                (data: any) => {
                    if (data && data.status === 200 && data.data && data.data.status === 200) {
                        res(true);
                    } else {
                        localStorage.removeItem('uid');
                        localStorage.removeItem('token');
                        this.router.navigate(['/login']);
                        res(false);
                    }
                },
                (error) => {
                    localStorage.removeItem('uid');
                    localStorage.removeItem('token');
                    this.router.navigate(['/login']);
                    res(false);
                }
            ).catch(error => {
                localStorage.removeItem('uid');
                localStorage.removeItem('token');
                this.router.navigate(['/login']);
                res(false);
            });

        });
    }
}
